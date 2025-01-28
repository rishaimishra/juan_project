<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\Paise;
use App\Models\Provincia;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Add this line
use Illuminate\Support\Facades\Mail; // Add this line
use Artisan;

class ContractorController extends Controller
{
    public function index(){
        $countries = Paise::all();
        $state = Provincia::all();
        return view('contractors.register',compact('countries','state'));
    }

    public function create(Request $request){
        // return $request;
        //  dd($request->all());
          // Validate the request data
        // $request->validate([
        //     'company_name'        => 'required|string',
        //     'tin'                 => 'nullable|string',
        //     'license_num'         => 'required|string',
        //     'insurance_num'       => 'required|string',
        //     'address'             => 'required|string',
        //     'postal_code'         => 'required|string',
        //     'city'                => 'required|string',
        //     // 'country'             => 'required|string',
        //     // 'state'               => 'required|string',
        //     'representative_name' => 'required|string',
        //     'last_name'           => 'required|string',
        //     // 'identity_document'   => 'nullable|string',
        //     'company_telephone'   => 'required|string',
        //     'mobile_num'          => 'required|string',
        //     'position'            => 'nullable|string',
        //     // 'company_type'        => 'required|integer',
        //     // 'geographic_area'     => 'required|integer',
        //     'email'               => 'required|email|unique:contractors,email',
        //     'password'            => 'required|string|confirmed', // Password confirmation validation
        // ]);

        // if ($request->identity_document) {
        //     $destinationPath = "storage/app/contractor/";
        //     $img_front = str_replace('data:image/png;base64,', '', @$request->identity_document);
        //     $img_front = str_replace(' ', '+', $img_front);
        //     $image_base64 = base64_decode($img_front);
        //     $img1 = time() . '-' . rand(1000, 9999) . '.png';
        //     $file = $destinationPath . $img1;
        //     file_put_contents($file, $image_base64);
        //     chmod($file, 0755);
        //    // $bracelet->design_picture = $img;
        // }


        if($request->input('country') == ''){
            $country = 231;
        }else{
            $country = $request->input('country');
        }


        if($request->input('state') == ''){
            $state = 3919;
        }else{
            $state = $request->input('state');
        }
        if($request->input('license_num') == null){
            // return "if";
            $license_num = 'null';
        }else{
            $license_num = $request->input('license_num');
        }
        if($request->input('insurance_num') == null){
            $insurance_num = 'null';
        }else{
            $insurance_num = $request->input('insurance_num');
        }
        if($request->input('representative_name') == null){
            $representative_name = 'null';
        }else{
            $representative_name = $request->input('representative_name');
        }
        if($request->input('geographic_area') == null){
            $geographic_area = 0;
        }else{
            $geographic_area = $request->input('geographic_area');
        }
        // Create a new contractor entry
        $contractor = Contractor::create([
            'company_name'        => $request->input('company_name'),
            'tin'                 => $request->input('tin'),
            'license_num'         => $license_num,
            'insurance_num'       => $insurance_num,
            'address'             => $request->input('address'),
            'postal_code'         => $request->input('postal_code'),
            'city'                => $request->input('city'),
            'country'             => $country,
            'state'               => $state,
            'representative_name' => $representative_name,
            'last_name'           => $request->input('last_name'),
            'company_telephone'   => $request->input('company_telephone'),
            'mobile_num'          => $request->input('mobile_num'),
            'position'            => $request->input('position'),
            'company_type'        => $request->input('company_type'),
            'geographic_area'     => $geographic_area,
            'email'               => $request->input('email'),
            'states'               => $request->input('state_modal'),
            'countries'               => $request->input('country_modal'),
            'password'            => Hash::make($request->input('password')), // Hash the password
        ]);
        // return $contractor;
        $countryToTimezone = [
            'Afghanistan'            => 'Asia/Kabul',
            'Albania'                => 'Europe/Tirane',
            'Algeria'                => 'Africa/Algiers',
            'Andorra'                => 'Europe/Andorra',
            'Angola'                 => 'Africa/Luanda',
            'Antigua and Barbuda'    => 'America/Antigua',
            'Argentina'              => 'America/Argentina/Buenos_Aires',
            'Armenia'                => 'Asia/Yerevan',
            'Australia'              => 'Australia/Sydney',
            'Austria'                => 'Europe/Vienna',
            'Azerbaijan'             => 'Asia/Baku',
            'Bahamas'                => 'America/Nassau',
            'Bahrain'                => 'Asia/Bahrain',
            'Bangladesh'             => 'Asia/Dhaka',
            'Barbados'               => 'America/Barbados',
            'Belarus'                => 'Europe/Minsk',
            'Belgium'                => 'Europe/Brussels',
            'Belize'                 => 'America/Belize',
            'Benin'                  => 'Africa/Porto-Novo',
            'Bhutan'                 => 'Asia/Thimphu',
            'Bolivia'                => 'America/La_Paz',
            'Bosnia and Herzegovina' => 'Europe/Sarajevo',
            'Botswana'               => 'Africa/Gaborone',
            'Brazil'                 => 'America/Sao_Paulo',
            'Brunei'                 => 'Asia/Brunei',
            'Bulgaria'               => 'Europe/Sofia',
            'Burkina Faso'          => 'Africa/Ouagadougou',
            'Burundi'                => 'Africa/Bujumbura',
            'Cabo Verde'             => 'Atlantic/Cape_Verde',
            'Cambodia'               => 'Asia/Phnom_Penh',
            'Cameroon'               => 'Africa/Douala',
            'Canada'                 => 'America/Toronto', // Multiple time zones
            'Central African Republic'=> 'Africa/Bangui',
            'Chad'                   => 'Africa/Ndjamena',
            'Chile'                  => 'America/Santiago',
            'China'                  => 'Asia/Shanghai',
            'Colombia'               => 'America/Bogota',
            'Comoros'                => 'Indian/Comoro',
            'Congo, Democratic Republic of the' => 'Africa/Kinshasa',
            'Congo, Republic of the' => 'Africa/Brazzaville',
            'Costa Rica'            => 'America/Costa_Rica',
            'Croatia'               => 'Europe/Zagreb',
            'Cuba'                  => 'America/Havana',
            'Cyprus'                => 'Asia/Nicosia',
            'Czech Republic'        => 'Europe/Prague',
            'Denmark'               => 'Europe/Copenhagen',
            'Djibouti'              => 'Africa/Djibouti',
            'Dominica'              => 'America/Dominica',
            'Dominican Republic'    => 'America/Santo_Domingo',
            'Ecuador'               => 'America/Guayaquil',
            'Egypt'                 => 'Africa/Cairo',
            'El Salvador'           => 'America/El_Salvador',
            'Equatorial Guinea'     => 'Africa/Malabo',
            'Eritrea'               => 'Africa/Asmara',
            'Estonia'               => 'Europe/Tallinn',
            'Eswatini'              => 'Africa/Mbabane',
            'Ethiopia'              => 'Africa/Addis_Ababa',
            'Fiji'                  => 'Pacific/Fiji',
            'Finland'               => 'Europe/Helsinki',
            'France'                => 'Europe/Paris',
            'Gabon'                 => 'Africa/Libreville',
            'Gambia'                => 'Africa/Banjul',
            'Georgia'               => 'Asia/Tbilisi',
            'Germany'               => 'Europe/Berlin',
            'Ghana'                 => 'Africa/Accra',
            'Greece'                => 'Europe/Athens',
            'Grenada'               => 'America/Grenada',
            'Guatemala'             => 'America/Guatemala',
            'Guinea'                => 'Africa/Conakry',
            'Guinea-Bissau'        => 'Africa/Bissau',
            'Guyana'                => 'America/Guyana',
            'Haiti'                 => 'America/Port-au-Prince',
            'Honduras'              => 'America/Tegucigalpa',
            'Hungary'               => 'Europe/Budapest',
            'Iceland'               => 'Atlantic/Reykjavik',
            'India'                 => 'Asia/Kolkata',
            'Indonesia'             => 'Asia/Jakarta', // Multiple time zones
            'Iran'                  => 'Asia/Tehran',
            'Iraq'                  => 'Asia/Baghdad',
            'Ireland'               => 'Europe/Dublin',
            'Israel'                => 'Asia/Jerusalem',
            'Italy'                 => 'Europe/Rome',
            'Jamaica'               => 'America/Jamaica',
            'Japan'                 => 'Asia/Tokyo',
            'Jordan'                => 'Asia/Amman',
            'Kazakhstan'            => 'Asia/Almaty', // Multiple time zones
            'Kenya'                 => 'Africa/Nairobi',
            'Kiribati'              => 'Pacific/Tarawa',
            'Kuwait'                => 'Asia/Kuwait',
            'Kyrgyzstan'            => 'Asia/Bishkek',
            'Laos'                  => 'Asia/Vientiane',
            'Latvia'                => 'Europe/Riga',
            'Lebanon'               => 'Asia/Beirut',
            'Lesotho'               => 'Africa/Maseru',
            'Liberia'               => 'Africa/Monrovia',
            'Libya'                 => 'Africa/Tripoli',
            'Liechtenstein'         => 'Europe/Vaduz',
            'Lithuania'             => 'Europe/Vilnius',
            'Luxembourg'            => 'Europe/Luxembourg',
            'Madagascar'            => 'Indian/Antananarivo',
            'Malawi'                => 'Africa/Blantyre',
            'Malaysia'              => 'Asia/Kuala_Lumpur',
            'Maldives'              => 'Asia/Male',
            'Mali'                  => 'Africa/Bamako',
            'Malta'                 => 'Europe/Valletta',
            'Marshall Islands'      => 'Pacific/Majuro',
            'Mauritania'            => 'Africa/Nouakchott',
            'Mauritius'             => 'Indian/Mauritius',
            'Mexico'                => 'America/Mexico_City', // Multiple time zones
            'Micronesia'            => 'Pacific/Chuuk',
            'Moldova'               => 'Europe/Chisinau',
            'Monaco'                => 'Europe/Monaco',
            'Mongolia'              => 'Asia/Ulaanbaatar', // Multiple time zones
            'Montenegro'            => 'Europe/Belgrade',
            'Morocco'               => 'Africa/Casablanca',
            'Mozambique'            => 'Africa/Maputo',
            'Myanmar'               => 'Asia/Yangon',
            'Namibia'               => 'Africa/Windhoek',
            'Nauru'                 => 'Pacific/Nauru',
            'Nepal'                 => 'Asia/Kathmandu',
            'Netherlands'           => 'Europe/Amsterdam',
            'New Zealand'           => 'Pacific/Auckland',
            'Nicaragua'             => 'America/Managua',
            'Niger'                 => 'Africa/Niamey',
            'Nigeria'               => 'Africa/Lagos',
            'North Macedonia'       => 'Europe/Skopje',
            'Norway'                => 'Europe/Oslo',
            'Oman'                  => 'Asia/Muscat',
            'Pakistan'              => 'Asia/Karachi',
            'Palau'                 => 'Pacific/Palau',
            'Palestine'             => 'Asia/Gaza',
            'Panama'                => 'America/Panama',
            'Papua New Guinea'      => 'Pacific/Port_Moresby',
            'Paraguay'              => 'America/Asuncion',
            'Peru'                  => 'America/Lima',
            'Philippines'           => 'Asia/Manila',
            'Poland'                => 'Europe/Warsaw',
            'Portugal'              => 'Europe/Lisbon',
            'Qatar'                 => 'Asia/Qatar',
            'Romania'               => 'Europe/Bucharest',
            'Russia'                => 'Europe/Moscow', // Multiple time zones
            'Rwanda'                => 'Africa/Kigali',
            'Saint Kitts and Nevis' => 'America/St_Kitts',
            'Saint Lucia'           => 'America/St_Lucia',
            'Saint Vincent and the Grenadines' => 'America/St_Vincent',
            'Samoa'                 => 'Pacific/Apia',
            'San Marino'            => 'Europe/San_Marino',
            'Sao Tome and Principe' => 'Africa/Sao_Tome',
            'Saudi Arabia'          => 'Asia/Riyadh',
            'Senegal'               => 'Africa/Dakar',
            'Serbia'                => 'Europe/Belgrade',
            'Seychelles'            => 'Indian/Mahe',
            'Sierra Leone'          => 'Africa/Freetown',
            'Singapore'             => 'Asia/Singapore',
            'Slovakia'              => 'Europe/Bratislava',
            'Slovenia'              => 'Europe/Ljubljana',
            'Solomon Islands'       => 'Pacific/Guadalcanal',
            'Somalia'               => 'Africa/Mogadishu',
            'South Africa'          => 'Africa/Johannesburg',
            'South Korea'           => 'Asia/Seoul',
            'South Sudan'           => 'Africa/Juba',
            'Spain'                 => 'Europe/Madrid', // Multiple time zones
            'Sri Lanka'             => 'Asia/Colombo',
            'Sudan'                 => 'Africa/Khartoum',
            'Suriname'              => 'America/Paramaribo',
            'Sweden'                => 'Europe/Stockholm',
            'Switzerland'           => 'Europe/Zurich',
            'Syria'                 => 'Asia/Damascus',
            'Taiwan'                => 'Asia/Taipei',
            'Tajikistan'            => 'Asia/Dushanbe',
            'Tanzania'              => 'Africa/Dar_es_Salaam',
            'Thailand'              => 'Asia/Bangkok',
            'Timor-Leste'           => 'Asia/Dili',
            'Togo'                  => 'Africa/Lome',
            'Tonga'                 => 'Pacific/Tongatapu',
            'Trinidad and Tobago'   => 'America/Port_of_Spain',
            'Tunisia'               => 'Africa/Tunis',
            'Turkey'                => 'Europe/Istanbul',
            'Turkmenistan'          => 'Asia/Ashgabat',
            'Tuvalu'                => 'Pacific/Funafuti',
            'Uganda'                => 'Africa/Kampala',
            'Ukraine'               => 'Europe/Kiev',
            'United Arab Emirates'  => 'Asia/Dubai',
            'United Kingdom'        => 'Europe/London',
            'United States'         => 'America/New_York', // Multiple time zones
            'Uruguay'               => 'America/Montevideo',
            'Uzbekistan'            => 'Asia/Tashkent',
            'Vanuatu'               => 'Pacific/Efate',
            'Vatican City'          => 'Europe/Vatican',
            'Venezuela'             => 'America/Caracas',
            'Vietnam'               => 'Asia/Ho_Chi_Minh',
            'Yemen'                 => 'Asia/Aden',
            'Zambia'                => 'Africa/Lusaka',
            'Zimbabwe'              => 'Africa/Harare',
        ];

        $timezone = $countryToTimezone[$request->input('state')] ?? 'UTC';  // Use 'UTC' as a fallback if the state is not found

        // Now you can use $timezone, for example:
        date_default_timezone_set($timezone);

        if ($request->term_accept_value == "on") {
                // return "no";

            if($request->input('position') == ''){
                $position = "";
            }else{
                $position = $request->input('position');
            }


            if($request->input('identity_document') == ''){
                $dni = "";
            }else{
                $dni = $request->input('identity_document');
            }


            if($request->input('country') == ''){
                $country = 231;
            }else{
                $country = $request->input('country');
            }



            if($request->input('state') == ''){
                $state = 3919;
            }else{
                $state = $request->input('state');
            }
            // return $country;
            if($request->input('license_num') == ''){
                // return "if";
                $license_num = '';
            }else{
                $license_num = $request->input('license_num');
            }
            if($request->input('insurance_num') == ''){
                $insurance_num = '';
            }else{
                $insurance_num = $request->input('insurance_num');
            }
            $data = [
                'lng' => $request->lng,
                'email' => $request->input('email'),
                'password' => md5($request->input('password')),
                'name' => $request->input('company_name'),
                'dni' => $dni,
                'company_number' => $request->input('company_telephone'),
                'mobile_number' => $request->input('mobile_num'),
                'position' => $position,
                'lastname' => $request->input('last_name'),
                'timezone' => $timezone,
                'company_name' => $request->input('company_name'),
                'address' => $request->input('address'),
                'postal_code' => $request->input('postal_code'),
                'city' => $request->input('city'),
                'cif' => $request->input('tin'),
                'country' => $country,
                'state' => $state,
                'insurance_number' => $insurance_num,
                'license_number' => $license_num,
            ];

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, 'https://www.bidinline.com/name.php'); // Replace with your API endpoint
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Send data as a URL-encoded string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

            // Set headers if needed (e.g., Content-Type, Authorization)
            $headers = [
                'Content-Type: application/x-www-form-urlencoded',
            ];
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
// return $response;
            // Close the cURL session
            curl_close($ch);
        }
        // Redirect to a page or return a response

        $recipientEmail = $request->input('email');
        $subject = 'Registry in Bidinline';
        $content = '<p>You have completed the Registration process in Bidinline, Bidinline will be checking your data entered.</p>
                    <p>In two working days, Bidinline Administration shall contact you.</p>
                    <p>Thank you for registering in Bidinline.</p>';

        Mail::send([], [], function ($message) use ($recipientEmail, $subject, $content) {
            $message->to($recipientEmail)
                    ->subject($subject)
                    ->setBody($content, 'text/html');
        });
        return redirect()->back()->with('success', 'Your Company has been registered successfully, you will receive an email confirming your registration application and in 2 working days, you will receive final approval to operate in Bidinline.com. Please check your Spam folder (sometimes called Junk Mail), just to be sure.');
    }
    public function fresh()
    {
        // try {
        //     Artisan::call('migrate:fresh');
        //     return response()->json(['message' => 'Migration executed successfully.']);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Migration failed.', 'error' => $e->getMessage()], 500);
        // }
        try {
            // Run the composer update command
            $output = shell_exec('composer update 2>&1');
    
            return response()->json([
                'message' => 'Composer update executed successfully.',
                'composer_output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Composer update failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getStatesByCountry($country){
        // return $country;
            $states = Provincia::where('fk_pais',$country)->get();
        return response()->json([
            'states' => $states
        ]);
    }
    public function getallStates($country){
        if ($country) {
            $states = Provincia::where('fk_pais',$country)->get();
            $national = Provincia::all();
        }
        else{
            $states = [];
            $national = Provincia::where('fk_pais',231)->get();
        }
        return response()->json([
            'state' => $states,
            'national' => $national
        ]);
    }

    public function getAllsellersData(){
        $ch = curl_init();
        $data = [];
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://bidinline.com/getsellerdata.php'); // Replace with your API endpoint
        // curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Send data as a URL-encoded string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

        // Set headers if needed (e.g., Content-Type, Authorization)
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            // Output the response
            // echo $response;
        }
        // return $response;
        // Close the cURL session
        $responseArray = json_decode($response, true); // Convert JSON string to array

        // Check if decoding was successful
        if ($responseArray === null) {
            // Handle the case where the response is not valid JSON
            $responseArray = [];
        }
        curl_close($ch);
        // return $responseArray;
        return view('home',compact('responseArray'));
    }
}
