<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\Paise;
use App\Models\Provincia;
use App\Models\User;
use App\Models\CompanyType;
use App\Models\Opportunity;
use App\Models\Invoice;
use Illuminate\Support\Facades\Hash; // Add this line
use Illuminate\Support\Facades\Mail; // Add this line
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use Artisan;

class ContractorController extends Controller
{
    public function index()
    {
        $countries = Paise::all();
        $state = Provincia::all();
        $company_type = CompanyType::all();
        $current_language = App::currentLocale();
        return view('contractors.register', compact('countries', 'state', 'company_type', 'current_language'));
    }

    public function create(Request $request)
    {
        // Step 1: Validate Request Data
        $request->validate(
            [
                'email' => 'required|email|unique:contractors,email',
            ],
            [
                'email.required' => 'The email field is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.unique' => 'This email address is already taken by another contractor.',
            ],
        );

        // Step 2: Prepare Data for External API
        $country = $request->input('country', 231); // Default to 231 if not provided
        $state = $request->input('state', 3919); // Default to 3919 if not provided
        $licenseNum = $request->input('license_num', 'null');
        $insuranceNum = $request->input('insurance_num', 'null');
        $representativeName = $request->input('representative_name', 'null');

        $data = [
            'lng' => $request->lng,
            'email' => $request->input('email'),
            'password' => md5($request->input('password')),
            'name' => $request->input('company_name'),
            'dni' => $request->input('identity_document', ''),
            'company_number' => $request->input('company_telephone'),
            'mobile_number' => $request->input('mobile_num'),
            'position' => $request->input('position', ''),
            'lastname' => $request->input('last_name'),
            'timezone' => $request->input('timezone', 'UTC'),
            'company_name' => $request->input('company_name'),
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'cif' => $request->input('tin', ''),
            'country' => $country,
            'state' => $state,
            'insurance_number' => $insuranceNum,
            'license_number' => $licenseNum,
        ];

        // Step 3: Validate Data with External API
        try {
            $ch = curl_init('https://www.bidinline.com/name.php');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
            curl_setopt($ch, CURLOPT_VERBOSE, true);

            $response = curl_exec($ch);

            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                throw new \Exception("cURL Error: $error");
            }

            curl_close($ch);

            // Validate response
            $responseData = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response: ' . json_last_error_msg());
            }

            \Log::info('API Response: ', $responseData);

        } catch (\Exception $e) {
            // Log the error
            \Log::error('API Call Failed: ' . $e->getMessage());

            // Store the error in the session
            return redirect()
                ->back()
                ->with('error', 'Failed to send data to the external API: ' . $e->getMessage());
        }

        // Step 4: Fetch Dependent Data
        $rejectedOpportunities = Invoice::pluck('opportunity_id')->toArray();
        $geographicArea = $request->input('geographic_area', []);
        $companyType = $request->input('company_type', []);

        $opportunities = Opportunity::whereIn('state', $geographicArea)
            ->where(function ($query) use ($companyType) {
                foreach ($companyType as $type) {
                    $query->orWhereJsonContains('project_type', $type);
                }
            })
            ->whereNotIn('id', $rejectedOpportunities)
            ->where('admin_bit', 2)
            ->select('id', 'opportunity_name')
            ->get();

        // Step 5: Create Contractor
        $contractor = Contractor::create([
            'company_name' => $request->input('company_name'),
            'tin' => $request->input('tin'),
            'license_num' => $licenseNum,
            'insurance_num' => $insuranceNum,
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'country' => $country,
            'state' => $state,
            'representative_name' => $representativeName,
            'last_name' => $request->input('last_name'),
            'company_telephone' => $request->input('company_telephone'),
            'mobile_num' => $request->input('mobile_num'),
            'position' => $request->input('position'),
            'company_type' => $companyType,
            'geographic_area' => json_encode($geographicArea),
            'email' => $request->input('email'),
            'states' => $geographicArea,
            'countries' => $request->input('country_modal'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Step 6: Create User
        $contrUser = User::create([
            'name' => $request->input('company_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'country' => $country,
            'state' => $state,
            'user_type' => 'contractor',
            'admin_bit' => 1,
            'home_telephone' => $request->input('company_telephone'),
            'mobile_num' => $request->input('mobile_num'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Step 7: Determine Timezone
        $countryToTimezone = [
            'Afghanistan' => 'Asia/Kabul',
            'Albania' => 'Europe/Tirane',
            'Algeria' => 'Africa/Algiers',
            'Andorra' => 'Europe/Andorra',
            'Angola' => 'Africa/Luanda',
            'Antigua and Barbuda' => 'America/Antigua',
            'Argentina' => 'America/Argentina/Buenos_Aires',
            'Armenia' => 'Asia/Yerevan',
            'Australia' => 'Australia/Sydney',
            'Austria' => 'Europe/Vienna',
            'Azerbaijan' => 'Asia/Baku',
            'Bahamas' => 'America/Nassau',
            'Bahrain' => 'Asia/Bahrain',
            'Bangladesh' => 'Asia/Dhaka',
            'Barbados' => 'America/Barbados',
            'Belarus' => 'Europe/Minsk',
            'Belgium' => 'Europe/Brussels',
            'Belize' => 'America/Belize',
            'Benin' => 'Africa/Porto-Novo',
            'Bhutan' => 'Asia/Thimphu',
            'Bolivia' => 'America/La_Paz',
            'Bosnia and Herzegovina' => 'Europe/Sarajevo',
            'Botswana' => 'Africa/Gaborone',
            'Brazil' => 'America/Sao_Paulo',
            'Brunei' => 'Asia/Brunei',
            'Bulgaria' => 'Europe/Sofia',
            'Burkina Faso' => 'Africa/Ouagadougou',
            'Burundi' => 'Africa/Bujumbura',
            'Cabo Verde' => 'Atlantic/Cape_Verde',
            'Cambodia' => 'Asia/Phnom_Penh',
            'Cameroon' => 'Africa/Douala',
            'Canada' => 'America/Toronto',
            'Central African Republic' => 'Africa/Bangui',
            'Chad' => 'Africa/Ndjamena',
            'Chile' => 'America/Santiago',
            'China' => 'Asia/Shanghai',
            'Colombia' => 'America/Bogota',
            'Comoros' => 'Indian/Comoro',
            'Congo, Democratic Republic of the' => 'Africa/Kinshasa',
            'Congo, Republic of the' => 'Africa/Brazzaville',
            'Costa Rica' => 'America/Costa_Rica',
            'Croatia' => 'Europe/Zagreb',
            'Cuba' => 'America/Havana',
            'Cyprus' => 'Asia/Nicosia',
            'Czech Republic' => 'Europe/Prague',
            'Denmark' => 'Europe/Copenhagen',
            'Djibouti' => 'Africa/Djibouti',
            'Dominica' => 'America/Dominica',
            'Dominican Republic' => 'America/Santo_Domingo',
            'Ecuador' => 'America/Guayaquil',
            'Egypt' => 'Africa/Cairo',
            'El Salvador' => 'America/El_Salvador',
            'Equatorial Guinea' => 'Africa/Malabo',
            'Eritrea' => 'Africa/Asmara',
            'Estonia' => 'Europe/Tallinn',
            'Eswatini' => 'Africa/Mbabane',
            'Ethiopia' => 'Africa/Addis_Ababa',
            'Fiji' => 'Pacific/Fiji',
            'Finland' => 'Europe/Helsinki',
            'France' => 'Europe/Paris',
            'Gabon' => 'Africa/Libreville',
            'Gambia' => 'Africa/Banjul',
            'Georgia' => 'Asia/Tbilisi',
            'Germany' => 'Europe/Berlin',
            'Ghana' => 'Africa/Accra',
            'Greece' => 'Europe/Athens',
            'Grenada' => 'America/Grenada',
            'Guatemala' => 'America/Guatemala',
            'Guinea' => 'Africa/Conakry',
            'Guinea-Bissau' => 'Africa/Bissau',
            'Guyana' => 'America/Guyana',
            'Haiti' => 'America/Port-au-Prince',
            'Honduras' => 'America/Tegucigalpa',
            'Hungary' => 'Europe/Budapest',
            'Iceland' => 'Atlantic/Reykjavik',
            'India' => 'Asia/Kolkata',
            'Indonesia' => 'Asia/Jakarta',
            'Iran' => 'Asia/Tehran',
            'Iraq' => 'Asia/Baghdad',
            'Ireland' => 'Europe/Dublin',
            'Israel' => 'Asia/Jerusalem',
            'Italy' => 'Europe/Rome',
            'Jamaica' => 'America/Jamaica',
            'Japan' => 'Asia/Tokyo',
            'Jordan' => 'Asia/Amman',
            'Kazakhstan' => 'Asia/Almaty',
            'Kenya' => 'Africa/Nairobi',
            'Kiribati' => 'Pacific/Tarawa',
            'Kuwait' => 'Asia/Kuwait',
            'Kyrgyzstan' => 'Asia/Bishkek',
            'Laos' => 'Asia/Vientiane',
            'Latvia' => 'Europe/Riga',
            'Lebanon' => 'Asia/Beirut',
            'Lesotho' => 'Africa/Maseru',
            'Liberia' => 'Africa/Monrovia',
            'Libya' => 'Africa/Tripoli',
            'Liechtenstein' => 'Europe/Vaduz',
            'Lithuania' => 'Europe/Vilnius',
            'Luxembourg' => 'Europe/Luxembourg',
            'Madagascar' => 'Indian/Antananarivo',
            'Malawi' => 'Africa/Blantyre',
            'Malaysia' => 'Asia/Kuala_Lumpur',
            'Maldives' => 'Asia/Male',
            'Mali' => 'Africa/Bamako',
            'Malta' => 'Europe/Valletta',
            'Marshall Islands' => 'Pacific/Majuro',
            'Mauritania' => 'Africa/Nouakchott',
            'Mauritius' => 'Indian/Mauritius',
            'Mexico' => 'America/Mexico_City',
            'Micronesia' => 'Pacific/Chuuk',
            'Moldova' => 'Europe/Chisinau',
            'Monaco' => 'Europe/Monaco',
            'Mongolia' => 'Asia/Ulaanbaatar',
            'Montenegro' => 'Europe/Podgorica',
            'Morocco' => 'Africa/Casablanca',
            'Mozambique' => 'Africa/Maputo',
            'Myanmar' => 'Asia/Yangon',
            'Namibia' => 'Africa/Windhoek',
            'Nauru' => 'Pacific/Nauru',
            'Nepal' => 'Asia/Kathmandu',
            'Netherlands' => 'Europe/Amsterdam',
            'New Zealand' => 'Pacific/Auckland',
            'Nicaragua' => 'America/Managua',
            'Niger' => 'Africa/Niamey',
            'Nigeria' => 'Africa/Lagos',
            'North Macedonia' => 'Europe/Skopje',
            'Norway' => 'Europe/Oslo',
            'Oman' => 'Asia/Muscat',
            'Pakistan' => 'Asia/Karachi',
            'Palau' => 'Pacific/Palau',
            'Palestine' => 'Asia/Gaza',
            'Panama' => 'America/Panama',
            'Papua New Guinea' => 'Pacific/Port_Moresby',
            'Paraguay' => 'America/Asuncion',
            'Peru' => 'America/Lima',
            'Philippines' => 'Asia/Manila',
            'Poland' => 'Europe/Warsaw',
            'Portugal' => 'Europe/Lisbon',
            'Qatar' => 'Asia/Qatar',
            'Romania' => 'Europe/Bucharest',
            'Russia' => 'Europe/Moscow',
            'Rwanda' => 'Africa/Kigali',
            'Saint Kitts and Nevis' => 'America/St_Kitts',
            'Saint Lucia' => 'America/St_Lucia',
            'Saint Vincent and the Grenadines' => 'America/St_Vincent',
            'Samoa' => 'Pacific/Apia',
            'San Marino' => 'Europe/San_Marino',
            'Sao Tome and Principe' => 'Africa/Sao_Tome',
            'Saudi Arabia' => 'Asia/Riyadh',
            'Senegal' => 'Africa/Dakar',
            'Serbia' => 'Europe/Belgrade',
            'Seychelles' => 'Indian/Mahe',
            'Sierra Leone' => 'Africa/Freetown',
            'Singapore' => 'Asia/Singapore',
            'Slovakia' => 'Europe/Bratislava',
            'Slovenia' => 'Europe/Ljubljana',
            'Solomon Islands' => 'Pacific/Guadalcanal',
            'Somalia' => 'Africa/Mogadishu',
            'South Africa' => 'Africa/Johannesburg',
            'South Korea' => 'Asia/Seoul',
            'South Sudan' => 'Africa/Juba',
            'Spain' => 'Europe/Madrid',
            'Sri Lanka' => 'Asia/Colombo',
            'Sudan' => 'Africa/Khartoum',
            'Suriname' => 'America/Paramaribo',
            'Sweden' => 'Europe/Stockholm',
            'Switzerland' => 'Europe/Zurich',
            'Syria' => 'Asia/Damascus',
            'Taiwan' => 'Asia/Taipei',
            'Tajikistan' => 'Asia/Dushanbe',
            'Tanzania' => 'Africa/Dar_es_Salaam',
            'Thailand' => 'Asia/Bangkok',
            'Timor-Leste' => 'Asia/Dili',
            'Togo' => 'Africa/Lome',
            'Tonga' => 'Pacific/Tongatapu',
            'Trinidad and Tobago' => 'America/Port_of_Spain',
            'Tunisia' => 'Africa/Tunis',
            'Turkey' => 'Europe/Istanbul',
            'Turkmenistan' => 'Asia/Ashgabat',
            'Tuvalu' => 'Pacific/Funafuti',
            'Uganda' => 'Africa/Kampala',
            'Ukraine' => 'Europe/Kyiv',
            'United Arab Emirates' => 'Asia/Dubai',
            'United Kingdom' => 'Europe/London',
            'United States' => 'America/New_York',
            'Uruguay' => 'America/Montevideo',
            'Uzbekistan' => 'Asia/Tashkent',
            'Vanuatu' => 'Pacific/Efate',
            'Vatican City' => 'Europe/Vatican',
            'Venezuela' => 'America/Caracas',
            'Vietnam' => 'Asia/Ho_Chi_Minh',
            'Yemen' => 'Asia/Aden',
            'Zambia' => 'Africa/Lusaka',
            'Zimbabwe' => 'Africa/Harare',
        ];

        $countryName = $request->input('country_name', 'United States'); // Default to 'United States'
        $timezone = $countryToTimezone[$countryName] ?? 'UTC'; // Default to UTC if not found
        date_default_timezone_set($timezone);

        // Step 7: Send Emails
        $recipientEmail = $request->input('email');
        $admin_email = 'juanfr@bidinline.com';

        $subject = Lang::get('message.email_subject');
        $subject_admin = 'A contractor registered to your website.';

        $content = '<p>' . Lang::get('message.email_content.paragraph_1') . '</p>' . '<p>' . Lang::get('message.email_content.paragraph_2') . '</p>' . '<p>' . Lang::get('message.email_content.paragraph_3') . '</p>';
        $admin_content = '<p>A company named ' . $request->input('company_name') . ' registered to your website.</p>';
        $opportunityListText = '<p></p>';
        foreach ($opportunities as $opportunityName) {
            $opportunityListText .= '<p>Name: ' . $opportunityName->opportunity_name . '</p>';
        }

        $content .= $opportunityListText;

        try {
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $content) {
                $message->to($recipientEmail)->subject($subject)->setBody($content, 'text/html');
            });

            Mail::send([], [], function ($message) use ($admin_email, $subject_admin, $admin_content) {
                $message->to($admin_email)->subject($subject_admin)->setBody($admin_content, 'text/html');
            });

            $msg = __('lang.success_message');
            return redirect()->back()->with('success', $msg);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to send email. Please try again later.');
        }
    }

    public function fresh()
    {
        try {
            Artisan::call('migrate:fresh');
            return response()->json(['message' => 'Migration executed successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Migration failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function getStatesByCountry($country)
    {
        // return $country;
        $states = Provincia::where('fk_pais', $country)->get();
        return response()->json([
            'states' => $states,
        ]);
    }
    public function getallStates($country)
    {
        if ($country) {
            $states = Provincia::where('fk_pais', $country)->get();
            $national = Provincia::all();
        } else {
            $states = [];
            $national = Provincia::where('fk_pais', 231)->get();
        }
        return response()->json([
            'state' => $states,
            'national' => $national,
        ]);
    }

    public function getAllSellersData()
    {
        // Initialize a cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://bidinline.com/getsellerdata.php'); // Replace with your API endpoint
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

        // Set headers if needed (e.g., Content-Type, Authorization)
        $headers = ['Content-Type: application/x-www-form-urlencoded'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the request and capture the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle cURL error (you can log it or display a message)
            $error = 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            return response()->json(['error' => $error], 500); // Return error as JSON
        }

        // Close the cURL session
        curl_close($ch);
        // dd($response);
        // Decode the JSON response
        $responseArray = json_decode($response, true); // Convert JSON string to array

        // Check if the response is valid JSON
        if ($responseArray === null && json_last_error() !== JSON_ERROR_NONE) {
            // Handle the case where the response is not valid JSON
            return response()->json(['error' => 'Invalid JSON response from API: ' . json_last_error_msg()], 500);
        }

        // Ensure the response is an array and contains the expected data
        if (!is_array($responseArray)) {
            return response()->json(['error' => 'Unexpected response format'], 500);
        }

        // Return data to the view, you can use the compact function
        return view('home', compact('responseArray'));
    }
    public function get_users()
    {
        $users = User::whereNotIn('user_type', ['admin', 'contractor'])
            ->where('admin_bit', '!=', 2)
            ->with(['countryList', 'stateList'])
            ->orderByDesc('id')
            ->get();

        if ($users->isEmpty()) {
            return view('users.list')->with('message', 'No users found.');
        }

        return view('users.list', compact('users'));
    }

    public function deleteUser($id){
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }


    public function get_contractor_email()
    {
        $data = [
            'email' => 'techxilix@gmail.com',
        ];
        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://www.bidinline.com/getcontractoremail.php'); // Replace with your API endpoint
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Send data as a URL-encoded string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

        // Set headers if needed (e.g., Content-Type, Authorization)
        $headers = ['Content-Type: application/x-www-form-urlencoded'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            // Output the response
            echo $response;
        }
        return $response;
        // Close the cURL session
        curl_close($ch);
    }
}
