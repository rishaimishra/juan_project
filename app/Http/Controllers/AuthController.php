<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biduser;
use App\Models\User;
use App\Models\Opportunity;
use App\Models\Contractor;
use App\Models\Paise;
use App\Models\Provincia;
use App\Models\CompanyType;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash; // Add this line
use Illuminate\Support\Facades\Mail; // Add this line
use Illuminate\Support\Facades\App;
class AuthController extends Controller
{
    public function login()
    {
        return view('users.user_login');
    }
    public function contractor_login_page()
    {
        return view('auth.contractor_login');
    }
    public function user_dashboard_page()
    {
        if (Auth::user()->user_type == 'user') {
            $user_id = Auth::user()->id;
            $opportunities = Opportunity::where('bidUser_id', $user_id)->get();
            $company_type = CompanyType::all();
            $current_language = App::currentLocale();
            return view('users.dashboard', compact('opportunities', 'company_type', 'current_language'));
        } else {
            $user = Auth::user();
            $contractor = Contractor::where('email', $user->email)->first();
            $company_type = CompanyType::all();
            $current_language = App::currentLocale();
            $geo_area = is_string($contractor->geographic_area) ? json_decode($contractor->geographic_area, true) : (is_array($contractor->geographic_area) ? $contractor->geographic_area : []);

            $oppCompanyType = is_string($contractor->company_type) ? json_decode($contractor->company_type, true) : (is_array($contractor->company_type) ? $contractor->company_type : []);
            // return $geo_area;
            // Query the `opportunities` table
            $opportunities = Opportunity::where('admin_bit', 2)
                ->get()
                ->filter(function ($opportunity) use ($geo_area, $oppCompanyType) {
                    $projectTypeMatch = false;
                    $stateMatch = false;

                    // Decode the project_type from the opportunities table
                    $opportunityProjectTypes = is_string($opportunity->project_type) ? json_decode($opportunity->project_type, true) : (is_array($opportunity->project_type) ? $opportunity->project_type : []);

                    // Check if there is any intersection in project types
                    foreach ($oppCompanyType as $type) {
                        if (in_array($type, $opportunityProjectTypes)) {
                            $projectTypeMatch = true;
                            break;
                        }
                    }

                    // Check if the state matches geographical area
                    if (in_array($opportunity->state, $geo_area)) {
                        $stateMatch = true;
                    }

                    // Return true if both conditions are met
                    return $projectTypeMatch && $stateMatch;
                });
            return view('contractors.dashboard', compact('opportunities', 'company_type', 'current_language'));
        }
    }
    public function contractor_dashboard_page()
    {
        return view('contractor_dashboard');
    }
    public function user_login(Request $request)
    {
        // return $request;
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            // 'password' => 'required|min:6', // Adjust according to your requirements
        ]);

        // Check if the user exists in the bid_user table
        $user = User::where('email', $request->email)->first();

        if ($user && password_verify($request->password, $user->password)) {
            if ($user->admin_bit == 0) {
                return back()->withErrors([
                    'error' => Lang::get('lang.text_account_not_approved'),
                ]);
            }

            if ($user->admin_bit == 2) {
                return back()->withErrors([
                    'error' => Lang::get('lang.text_account_not_approved'),
                ]);
            }

            if ($user->user_type != 'user') {
                return back()->withErrors([
                    'error' => Lang::get('lang.text_account_type_restriction'),
                ]);
            }
            // If the credentials are valid, log the user in
            Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            // return $user;
            return redirect()->route('users-dashboard');
        }

        // If authentication fails, return back with an error message
        return back()->withErrors([
            'error' => Lang::get('lang.text_invalid_credentials'),
        ]);
    }
    public function contractor_login(Request $request)
    {
        // return $request;
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6', // Adjust according to your requirements
        ]);

        // Check if the user exists in the bid_user table
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $contrUser = Contractor::where('email', $request->email)->first();
            if ($contrUser) {
                $saveContrUser = User::create([
                    'name' => $contrUser->company_name,
                    'last_name' => $contrUser->last_name,
                    'address' => $contrUser->address,
                    'postal_code' => $contrUser->postal_code,
                    'city' => $contrUser->city,
                    'country' => $contrUser->country,
                    'state' => $contrUser->state,
                    'user_type' => 'contractor',
                    'admin_bit' => 1,
                    'home_telephone' => $contrUser->company_telephone,
                    'mobile_num' => $contrUser->company_telephone,
                    'email' => $contrUser->email,
                    'password' => $contrUser->password, // Hash the password
                ]);

                if ($contrUser && password_verify($request->password, $contrUser->password)) {
                    // $checkemail = $this->get_contractor_email($request->email);
                    // if ($checkemail != '1') {
                    //     return back()->withErrors([
                    //         'error' => Lang::get('lang.text_account_not_approved'),
                    //     ]);
                    // }
                    Auth::attempt(['email' => $request->email, 'password' => $request->password]);
                    return redirect()->route('users-dashboard');

                    if ($contrUser->user_type != 'contractor') {
                        return back()->withErrors([
                            'email' => Lang::get('lang.do_not_match'),
                            // 'error' => Lang::get('lang.text_account_not_approved'),
                        ]);
                    }
                } else {
                    return back()->withErrors([
                        'email' => Lang::get('lang.do_not_match'),
                    ]);
                }
            } else {
                return back()->withErrors([
                    'email' => Lang::get('lang.do_not_match'),
                    // 'error' => Lang::get('lang.text_account_not_approved'),
                ]);
            }
        } else {
            if ($user && password_verify($request->password, $user->password)) {
                // $checkemail = $this->get_contractor_email($request->email);
                // if ($checkemail != '1') {
                //     return back()->withErrors([
                //         'error' => Lang::get('lang.text_account_not_approved'),
                //     ]);
                // }
                Auth::attempt(['email' => $request->email, 'password' => $request->password]);
                return redirect()->route('users-dashboard');

                if ($user->user_type != 'contractor') {
                    return back()->withErrors([
                        'email' => Lang::get('lang.do_not_match'),
                        // 'error' => Lang::get('lang.text_account_not_approved'),
                    ]);
                }
            } else {
                return back()->withErrors([
                    'email' => Lang::get('lang.do_not_match'),
                ]);
            }
        }
    }

    public function admin_approve($id)
    {
        $user = User::where('id', $id)->first();
        $user->admin_bit = 1;
        $user->save();
        $currentLocale = App::currentLocale();

        // Set the locale for email content
        App::setLocale($currentLocale);

        $recipientEmail = $user->email;

        // Get the email subject and content using localization
        $subject = Lang::get('message.email_subject');

        $content = '<p>' . Lang::get('message.email_content.paragraph_3') . '</p>';
        try {
            // return $response;
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $content) {
                $message->to($recipientEmail)->subject($subject)->setBody($content, 'text/html');
            });
            $msg = __('lang.success_message') . ' ' . $response;

            return redirect()->back()->with('success', 'User approved successfully');
            // return redirect()->back()->with('success',  $msg);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to send email. Please try again later.');
        }
    }
    public function admin_reject($id)
    {
        $user = User::where('id', $id)->first();
        $user->admin_bit = 2;
        $user->save();

        $currentLocale = App::currentLocale();

        // Set the locale for email content
        App::setLocale($currentLocale);

        $recipientEmail = $user->email;

        // Get the email subject and content using localization
        $subject = Lang::get('message.email_subject_reject');

        $content = '<p>' . Lang::get('message.email_content.paragraph_4') . '</p>';
        try {
            // return $response;
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $content) {
                $message->to($recipientEmail)->subject($subject)->setBody($content, 'text/html');
            });
            $msg = __('lang.success_message') . ' ' . $response;

            return redirect()->back()->with('success', 'User rejected successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to send email. Please try again later.');
        }
    }
    public function customLogout(Request $request)
    {
        // Custom action before logout (optional)
        // Log::info('User logging out', ['user_id' => Auth::id()]);

        // Log the user out
        Auth::logout();

        // Optional: Invalidate the session to further secure the logout
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect with a custom message
        return redirect()->route('user-login');
    }
    public function forget_password()
    {
        return view('users.forget_password');
    }

    public function send_forget_password(Request $request)
    {
        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists
        if ($user) {
            // Generate an 8-digit random password
            $plainPassword = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);

            // Hash the password
            $hashedPassword = Hash::make($plainPassword);

            // Update the user's password in the database
            $user->password = $hashedPassword;
            $user->save();

            // Send the plain password to the user's email
            // $emailContent = "Hello, your new password is: $plainPassword";

            $content = '<p>' . Lang::get('message.dear_user') . '</p>' . '<p>' . Lang::get('message.new_password_line') . ' ' . $plainPassword . ' ' . Lang::get('message.new_password_line_two') . '</p>' . '<p>' . Lang::get('message.best_regards') . '<br>' . Lang::get('message.bidline_admin');

            $subject = Lang::get('message.your_new_password');
            $recipientEmail = $user->email;
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $content) {
                $message->to($recipientEmail)->subject($subject)->setBody($content, 'text/html');
            });

            // Mail::raw($content, function ($message) use ($user) {
            //     $message->to($user->email)
            //             ->subject($subject);
            // });
            $send_email_message = Lang::get('lang.new_password_send');

            return redirect()->back()->with('success', $send_email_message);
        }

        // Return an error response if the user doesn't exist
        $send_email_message_error = Lang::get('lang.email_does_not');

        return redirect()->back()->with('error', $send_email_message_error);
    }
    public function get_contractor_email($email)
    {
        $data = [
            'email' => $email,
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
        //  die;
        // Close the cURL session
        curl_close($ch);
    }
    public function edit_profile($id)
    {
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://bidinline.com/getreferal.php'); // Replace with your API endpoint
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
        $accossiations = $responseArray;
        $user = User::where('id', $id)->first();
        $user_type = $user->user_type;
        return view('users.edit_profile', compact('accossiations', 'user', 'user_type'));
    }
    public function update_profile(Request $request)
    {
        if ($request->user_type == 'user') {
            // Validate the input
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:10',
                'city' => 'nullable|string|max:100',
                // 'country'         => 'nullable|string|max:100',
                // 'state'           => 'nullable|string|max:100',
                'home_telephone' => 'nullable|string|max:15',
                'mobile_num' => 'nullable|string|max:15',
                'association' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255|unique:users,email,' . $request->user_id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            // Fetch the user by ID
            $user = User::findOrFail($validatedData['user_id']);

            // Update the user fields
            $user->update([
                'name' => $request->input('name', $user->name),
                'last_name' => $request->input('last_name', $user->last_name),
                'address' => $request->input('address', $user->address),
                'postal_code' => $request->input('postal_code', $user->postal_code),
                'city' => $request->input('city', $user->city),
                // 'country'         => $request->input('country', $user->country),
                // 'state'           => $request->input('state', $user->state),
                'home_telephone' => $request->input('home_telephone', $user->home_telephone),
                'mobile_num' => $request->input('mobile_num', $user->mobile_num),
                'association' => $request->input('association', $user->association),
                'email' => $request->input('email', $user->email),
                'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
            ]);

            $profile_updated = Lang::get('lang.profile_updated');
            // Redirect with success message
            return redirect()->route('users-dashboard')->with('success', $profile_updated);
        } else {
            $profile_not_updated = Lang::get('lang.profile_updated');
            return redirect()->route('users-dashboard')->with('success', $profile_not_updated);
        }
    }

    public function edit_contractor_profile($id)
    {
        // return $id;
        $countries = Paise::all();
        $company_type = CompanyType::all();
        $user_email = User::where('id', $id)->pluck('email');
        $contractor = Contractor::where('email', $user_email)->first();
        // return $contractor;
        $state = Provincia::where('fk_pais', $contractor->country)->get();
        return view('users.edit_contractor_profile', compact('countries', 'state', 'contractor', 'company_type'));
    }

    public function update_contractor_profile(Request $request)
    {
        $contractor = Contractor::where('email', $request->email)->first();

        if ($request->input('country') == '') {
            $country = 231;
        } else {
            $country = $request->input('country');
        }

        // if($request->input('state') == ''){
        //     $state = 3919;
        // }else{
        //     $state = $request->input('state');
        // }
        // if($request->input('license_num') == null){
        //     // return "if";
        //     $license_num = 'null';
        // }else{
        //     $license_num = $request->input('license_num');
        // }
        // if($request->input('insurance_num') == null){
        //     $insurance_num = 'null';
        // }else{
        //     $insurance_num = $request->input('insurance_num');
        // }
        // if($request->input('representative_name') == null){
        //     $representative_name = 'null';
        // }else{
        //     $representative_name = $request->input('representative_name');
        // }
        if ($request->input('geographic_area') == null) {
            $geographic_area = 0;
        } else {
            $geographic_area = $request->input('geographic_area');
        }
        // Create a new contractor entry
        $contractor->update([
            // 'company_name'        => $request->input('company_name'),
            // 'tin'                 => $request->input('tin'),
            // 'license_num'         => $license_num,
            // 'insurance_num'       => $insurance_num,
            // 'address'             => $request->input('address'),
            // 'postal_code'         => $request->input('postal_code'),
            // 'city'                => $request->input('city'),
            'country' => $country,
            // 'state'               => $state,
            // 'representative_name' => $representative_name,
            // 'last_name'           => $request->input('last_name'),
            // 'company_telephone'   => $request->input('company_telephone'),
            // 'mobile_num'          => $request->input('mobile_num'),
            // 'position'            => $request->input('position'),
            'company_type' => $request->input('company_type'),
            'geographic_area' => $geographic_area,
            // 'email'               => $request->input('email'),
            // 'states'               => $request->input('state_modal'),
            // 'countries'               => $request->input('country_modal'),
            'password' => Hash::make($request->input('password')), // Hash the password
        ]);

        $contrUser = User::where('email', $request->email)->first();
        $contrUser->update([
            // 'name'        => $request->input('company_name'),
            // 'last_name'           => $request->input('last_name'),
            // 'address'             => $request->input('address'),
            // 'postal_code'         => $request->input('postal_code'),
            // 'city'                => $request->input('city'),
            // 'country'             => $country,
            // 'state'               => $state,
            // 'user_type'           =>'contractor',
            // 'admin_bit'            => 1,
            // 'home_telephone'   => $request->input('company_telephone'),
            // 'mobile_num'          => $request->input('company_telephone'),
            // 'email'               => $request->input('email'),
            'password' => Hash::make($request->input('password')), // Hash the password
        ]);
        $profile_updated = Lang::get('lang.profile_updated');
        return back()->with('success', $profile_updated);
        // return $contractor;
        //         $countryToTimezone = [
        //             'Afghanistan'            => 'Asia/Kabul',
        //             'Albania'                => 'Europe/Tirane',
        //             'Algeria'                => 'Africa/Algiers',
        //             'Andorra'                => 'Europe/Andorra',
        //             'Angola'                 => 'Africa/Luanda',
        //             'Antigua and Barbuda'    => 'America/Antigua',
        //             'Argentina'              => 'America/Argentina/Buenos_Aires',
        //             'Armenia'                => 'Asia/Yerevan',
        //             'Australia'              => 'Australia/Sydney',
        //             'Austria'                => 'Europe/Vienna',
        //             'Azerbaijan'             => 'Asia/Baku',
        //             'Bahamas'                => 'America/Nassau',
        //             'Bahrain'                => 'Asia/Bahrain',
        //             'Bangladesh'             => 'Asia/Dhaka',
        //             'Barbados'               => 'America/Barbados',
        //             'Belarus'                => 'Europe/Minsk',
        //             'Belgium'                => 'Europe/Brussels',
        //             'Belize'                 => 'America/Belize',
        //             'Benin'                  => 'Africa/Porto-Novo',
        //             'Bhutan'                 => 'Asia/Thimphu',
        //             'Bolivia'                => 'America/La_Paz',
        //             'Bosnia and Herzegovina' => 'Europe/Sarajevo',
        //             'Botswana'               => 'Africa/Gaborone',
        //             'Brazil'                 => 'America/Sao_Paulo',
        //             'Brunei'                 => 'Asia/Brunei',
        //             'Bulgaria'               => 'Europe/Sofia',
        //             'Burkina Faso'          => 'Africa/Ouagadougou',
        //             'Burundi'                => 'Africa/Bujumbura',
        //             'Cabo Verde'             => 'Atlantic/Cape_Verde',
        //             'Cambodia'               => 'Asia/Phnom_Penh',
        //             'Cameroon'               => 'Africa/Douala',
        //             'Canada'                 => 'America/Toronto', // Multiple time zones
        //             'Central African Republic'=> 'Africa/Bangui',
        //             'Chad'                   => 'Africa/Ndjamena',
        //             'Chile'                  => 'America/Santiago',
        //             'China'                  => 'Asia/Shanghai',
        //             'Colombia'               => 'America/Bogota',
        //             'Comoros'                => 'Indian/Comoro',
        //             'Congo, Democratic Republic of the' => 'Africa/Kinshasa',
        //             'Congo, Republic of the' => 'Africa/Brazzaville',
        //             'Costa Rica'            => 'America/Costa_Rica',
        //             'Croatia'               => 'Europe/Zagreb',
        //             'Cuba'                  => 'America/Havana',
        //             'Cyprus'                => 'Asia/Nicosia',
        //             'Czech Republic'        => 'Europe/Prague',
        //             'Denmark'               => 'Europe/Copenhagen',
        //             'Djibouti'              => 'Africa/Djibouti',
        //             'Dominica'              => 'America/Dominica',
        //             'Dominican Republic'    => 'America/Santo_Domingo',
        //             'Ecuador'               => 'America/Guayaquil',
        //             'Egypt'                 => 'Africa/Cairo',
        //             'El Salvador'           => 'America/El_Salvador',
        //             'Equatorial Guinea'     => 'Africa/Malabo',
        //             'Eritrea'               => 'Africa/Asmara',
        //             'Estonia'               => 'Europe/Tallinn',
        //             'Eswatini'              => 'Africa/Mbabane',
        //             'Ethiopia'              => 'Africa/Addis_Ababa',
        //             'Fiji'                  => 'Pacific/Fiji',
        //             'Finland'               => 'Europe/Helsinki',
        //             'France'                => 'Europe/Paris',
        //             'Gabon'                 => 'Africa/Libreville',
        //             'Gambia'                => 'Africa/Banjul',
        //             'Georgia'               => 'Asia/Tbilisi',
        //             'Germany'               => 'Europe/Berlin',
        //             'Ghana'                 => 'Africa/Accra',
        //             'Greece'                => 'Europe/Athens',
        //             'Grenada'               => 'America/Grenada',
        //             'Guatemala'             => 'America/Guatemala',
        //             'Guinea'                => 'Africa/Conakry',
        //             'Guinea-Bissau'        => 'Africa/Bissau',
        //             'Guyana'                => 'America/Guyana',
        //             'Haiti'                 => 'America/Port-au-Prince',
        //             'Honduras'              => 'America/Tegucigalpa',
        //             'Hungary'               => 'Europe/Budapest',
        //             'Iceland'               => 'Atlantic/Reykjavik',
        //             'India'                 => 'Asia/Kolkata',
        //             'Indonesia'             => 'Asia/Jakarta', // Multiple time zones
        //             'Iran'                  => 'Asia/Tehran',
        //             'Iraq'                  => 'Asia/Baghdad',
        //             'Ireland'               => 'Europe/Dublin',
        //             'Israel'                => 'Asia/Jerusalem',
        //             'Italy'                 => 'Europe/Rome',
        //             'Jamaica'               => 'America/Jamaica',
        //             'Japan'                 => 'Asia/Tokyo',
        //             'Jordan'                => 'Asia/Amman',
        //             'Kazakhstan'            => 'Asia/Almaty', // Multiple time zones
        //             'Kenya'                 => 'Africa/Nairobi',
        //             'Kiribati'              => 'Pacific/Tarawa',
        //             'Kuwait'                => 'Asia/Kuwait',
        //             'Kyrgyzstan'            => 'Asia/Bishkek',
        //             'Laos'                  => 'Asia/Vientiane',
        //             'Latvia'                => 'Europe/Riga',
        //             'Lebanon'               => 'Asia/Beirut',
        //             'Lesotho'               => 'Africa/Maseru',
        //             'Liberia'               => 'Africa/Monrovia',
        //             'Libya'                 => 'Africa/Tripoli',
        //             'Liechtenstein'         => 'Europe/Vaduz',
        //             'Lithuania'             => 'Europe/Vilnius',
        //             'Luxembourg'            => 'Europe/Luxembourg',
        //             'Madagascar'            => 'Indian/Antananarivo',
        //             'Malawi'                => 'Africa/Blantyre',
        //             'Malaysia'              => 'Asia/Kuala_Lumpur',
        //             'Maldives'              => 'Asia/Male',
        //             'Mali'                  => 'Africa/Bamako',
        //             'Malta'                 => 'Europe/Valletta',
        //             'Marshall Islands'      => 'Pacific/Majuro',
        //             'Mauritania'            => 'Africa/Nouakchott',
        //             'Mauritius'             => 'Indian/Mauritius',
        //             'Mexico'                => 'America/Mexico_City', // Multiple time zones
        //             'Micronesia'            => 'Pacific/Chuuk',
        //             'Moldova'               => 'Europe/Chisinau',
        //             'Monaco'                => 'Europe/Monaco',
        //             'Mongolia'              => 'Asia/Ulaanbaatar', // Multiple time zones
        //             'Montenegro'            => 'Europe/Belgrade',
        //             'Morocco'               => 'Africa/Casablanca',
        //             'Mozambique'            => 'Africa/Maputo',
        //             'Myanmar'               => 'Asia/Yangon',
        //             'Namibia'               => 'Africa/Windhoek',
        //             'Nauru'                 => 'Pacific/Nauru',
        //             'Nepal'                 => 'Asia/Kathmandu',
        //             'Netherlands'           => 'Europe/Amsterdam',
        //             'New Zealand'           => 'Pacific/Auckland',
        //             'Nicaragua'             => 'America/Managua',
        //             'Niger'                 => 'Africa/Niamey',
        //             'Nigeria'               => 'Africa/Lagos',
        //             'North Macedonia'       => 'Europe/Skopje',
        //             'Norway'                => 'Europe/Oslo',
        //             'Oman'                  => 'Asia/Muscat',
        //             'Pakistan'              => 'Asia/Karachi',
        //             'Palau'                 => 'Pacific/Palau',
        //             'Palestine'             => 'Asia/Gaza',
        //             'Panama'                => 'America/Panama',
        //             'Papua New Guinea'      => 'Pacific/Port_Moresby',
        //             'Paraguay'              => 'America/Asuncion',
        //             'Peru'                  => 'America/Lima',
        //             'Philippines'           => 'Asia/Manila',
        //             'Poland'                => 'Europe/Warsaw',
        //             'Portugal'              => 'Europe/Lisbon',
        //             'Qatar'                 => 'Asia/Qatar',
        //             'Romania'               => 'Europe/Bucharest',
        //             'Russia'                => 'Europe/Moscow', // Multiple time zones
        //             'Rwanda'                => 'Africa/Kigali',
        //             'Saint Kitts and Nevis' => 'America/St_Kitts',
        //             'Saint Lucia'           => 'America/St_Lucia',
        //             'Saint Vincent and the Grenadines' => 'America/St_Vincent',
        //             'Samoa'                 => 'Pacific/Apia',
        //             'San Marino'            => 'Europe/San_Marino',
        //             'Sao Tome and Principe' => 'Africa/Sao_Tome',
        //             'Saudi Arabia'          => 'Asia/Riyadh',
        //             'Senegal'               => 'Africa/Dakar',
        //             'Serbia'                => 'Europe/Belgrade',
        //             'Seychelles'            => 'Indian/Mahe',
        //             'Sierra Leone'          => 'Africa/Freetown',
        //             'Singapore'             => 'Asia/Singapore',
        //             'Slovakia'              => 'Europe/Bratislava',
        //             'Slovenia'              => 'Europe/Ljubljana',
        //             'Solomon Islands'       => 'Pacific/Guadalcanal',
        //             'Somalia'               => 'Africa/Mogadishu',
        //             'South Africa'          => 'Africa/Johannesburg',
        //             'South Korea'           => 'Asia/Seoul',
        //             'South Sudan'           => 'Africa/Juba',
        //             'Spain'                 => 'Europe/Madrid', // Multiple time zones
        //             'Sri Lanka'             => 'Asia/Colombo',
        //             'Sudan'                 => 'Africa/Khartoum',
        //             'Suriname'              => 'America/Paramaribo',
        //             'Sweden'                => 'Europe/Stockholm',
        //             'Switzerland'           => 'Europe/Zurich',
        //             'Syria'                 => 'Asia/Damascus',
        //             'Taiwan'                => 'Asia/Taipei',
        //             'Tajikistan'            => 'Asia/Dushanbe',
        //             'Tanzania'              => 'Africa/Dar_es_Salaam',
        //             'Thailand'              => 'Asia/Bangkok',
        //             'Timor-Leste'           => 'Asia/Dili',
        //             'Togo'                  => 'Africa/Lome',
        //             'Tonga'                 => 'Pacific/Tongatapu',
        //             'Trinidad and Tobago'   => 'America/Port_of_Spain',
        //             'Tunisia'               => 'Africa/Tunis',
        //             'Turkey'                => 'Europe/Istanbul',
        //             'Turkmenistan'          => 'Asia/Ashgabat',
        //             'Tuvalu'                => 'Pacific/Funafuti',
        //             'Uganda'                => 'Africa/Kampala',
        //             'Ukraine'               => 'Europe/Kiev',
        //             'United Arab Emirates'  => 'Asia/Dubai',
        //             'United Kingdom'        => 'Europe/London',
        //             'United States'         => 'America/New_York', // Multiple time zones
        //             'Uruguay'               => 'America/Montevideo',
        //             'Uzbekistan'            => 'Asia/Tashkent',
        //             'Vanuatu'               => 'Pacific/Efate',
        //             'Vatican City'          => 'Europe/Vatican',
        //             'Venezuela'             => 'America/Caracas',
        //             'Vietnam'               => 'Asia/Ho_Chi_Minh',
        //             'Yemen'                 => 'Asia/Aden',
        //             'Zambia'                => 'Africa/Lusaka',
        //             'Zimbabwe'              => 'Africa/Harare',
        //         ];

        //         $timezone = $countryToTimezone[$request->input('state')] ?? 'UTC';  // Use 'UTC' as a fallback if the state is not found

        //         // Now you can use $timezone, for example:
        //         date_default_timezone_set($timezone);

        //         // if ($request->term_accept_value == "on") {
        //                 // return "no";

        //             if($request->input('position') == ''){
        //                 $position = "";
        //             }else{
        //                 $position = $request->input('position');
        //             }

        //             if($request->input('identity_document') == ''){
        //                 $dni = "";
        //             }else{
        //                 $dni = $request->input('identity_document');
        //             }

        //             if($request->input('country') == ''){
        //                 $country = 231;
        //             }else{
        //                 $country = $request->input('country');
        //             }

        //             if($request->input('state') == ''){
        //                 $state = 3919;
        //             }else{
        //                 $state = $request->input('state');
        //             }

        //             if($request->input('license_num') == ''){
        //                 $license_num = '';
        //             }else{
        //                 $license_num = $request->input('license_num');
        //             }

        //             if($request->input('insurance_num') == ''){
        //                 $insurance_num = '';
        //             }else{
        //                 $insurance_num = $request->input('insurance_num');
        //             }

        //             if($request->input('tin') == ''){
        //                 $tin = '';
        //             }else{
        //                 $tin = $request->input('tin');
        //             }
        //             $data = [
        //                 'lng' => $request->lng,
        //                 'email' => $request->input('email'),
        //                 'password' => md5($request->input('password')),
        //                 'name' => $request->input('company_name'),
        //                 'dni' => $dni,
        //                 'company_number' => $request->input('company_telephone'),
        //                 'mobile_number' => $request->input('mobile_num'),
        //                 'position' => $position,
        //                 'lastname' => $request->input('last_name'),
        //                 'timezone' => $timezone,
        //                 'company_name' => $request->input('company_name'),
        //                 'address' => $request->input('address'),
        //                 'postal_code' => $request->input('postal_code'),
        //                 'city' => $request->input('city'),
        //                 'cif' => $tin,
        //                 'country' => $country,
        //                 'state' => $state,
        //                 'insurance_number' => $insurance_num,
        //                 'license_number' => $license_num,
        //             ];

        //             // Initialize cURL session
        //             $ch = curl_init();

        //             // Set cURL options
        //             curl_setopt($ch, CURLOPT_URL, 'https://www.bidinline.com/updatecontractor.php'); // Replace with your API endpoint
        //             curl_setopt($ch, CURLOPT_POST, 1);
        //             curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Send data as a URL-encoded string
        //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

        //             // Set headers if needed (e.g., Content-Type, Authorization)
        //             $headers = [
        //                 'Content-Type: application/x-www-form-urlencoded',
        //             ];
        //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //             // Execute the request
        //             $response = curl_exec($ch);

        //             // Check for errors
        //             if (curl_errno($ch)) {
        //                 echo 'Error: ' . curl_error($ch);
        //             } else {
        //                 // Output the response
        //                 echo $response;
        //             }
        // return $response;
        //             // Close the cURL session
        //             curl_close($ch);
    }
}
