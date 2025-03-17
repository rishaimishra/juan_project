<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biduser;
use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash; // Add this line
use Illuminate\Support\Facades\Mail; // Add this line
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use App\Models\Provincia;
use Illuminate\Support\Facades\Auth;
use App\Models\Paise;
use App\Models\CompanyType;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index()
    {
        // Initialize a cURL session
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
        return view('users.register', compact('accossiations'));
    }

    public function userWithJobIndex()
    {
        $response = Http::withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])->get('https://bidinline.com/getreferal.php');

        if ($response->failed()) {
            return response()->json(['error' => 'API request failed'], 500);
        }

        $responseArray = $response->json();

        if (!is_array($responseArray)) {
            return response()->json(['error' => 'Unexpected response format'], 500);
        }
        $current_language = App::currentLocale();
        $user = Auth::user();
        $user_country = Paise::all();
        $states = Provincia::all();
        $company_type = CompanyType::all();

        return view('users.user_register_with_job', ['accossiations' => $responseArray, 'current_language' => $current_language, 'states' => $states, 'user_country' => $user_country, 'company_type' => $company_type]);
    }

    public function create(Request $request)
    {
        //  dd($request->all());
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            // 'country'             => 'required|string|max:255',
            // 'state'               => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'identity_document'   => 'nullable|string|max:255',
            // 'home_telephone'   => 'required|string|max:20',
            'mobile_num' => 'required|string|max:20',
            'association' => 'nullable|string|max:255',
            // 'company_type'        => 'required|integer',
            // 'geographic_area'     => 'required|integer',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Password confirmation validation
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Email exists, redirect back with an error message
            return redirect()->back()->with('error', 'This email is already registered.');
        }
        if ($request->identity_document) {
            $destinationPath = 'storage/app/contractor/';
            $img_front = str_replace('data:image/png;base64,', '', @$request->identity_document);
            $img_front = str_replace(' ', '+', $img_front);
            $image_base64 = base64_decode($img_front);
            $img1 = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img1;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            // $bracelet->design_picture = $img;
        }

        // Create a new contractor entry
        $contractor = User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'home_telephone' => $request->input('home_telephone'),
            'mobile_num' => $request->input('mobile_num'),
            'association' => $request->input('association'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')), // Hash the password
            'user_type' => 'user',
        ]);
        // Redirect to a page or return a response
        $currentLocale = App::currentLocale();

        // Set the locale for email content
        App::setLocale($currentLocale);

        $recipientEmail = $request->input('email');
        $admin_email = 'juanfr@bidinline.com';
        // Get the email subject and content using localization
        $subject = Lang::get('message.email_subject');
        $subject_admin = 'An user register to your website.';
        $content = '<p>' . Lang::get('message.email_content.paragraph_1') . '</p>' . '<p>' . Lang::get('message.email_content.paragraph_2') . '</p>' . '<p>' . Lang::get('message.email_content.paragraph_3') . '</p>';

        $admin_content = '<p>An user name : ' . $request->input('name') . ' register to your website.</p>';
        // $content = '<p> Welcome to registration </p>';
        try {
            // return $response;
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $content) {
                $message->to($recipientEmail)->subject($subject)->setBody($content, 'text/html');
            });

            Mail::send([], [], function ($message) use ($admin_email, $subject_admin, $admin_content) {
                $message->to($admin_email)->subject($subject_admin)->setBody($admin_content, 'text/html');
            });

            $msg = __('lang.user_success_message');
            return redirect()->back()->with('success', $msg);

            // $msg = __('lang.success_message')." ".$response;

            // return redirect()->back()->with('success', 'User created successfully!');
            // return redirect()->back()->with('success',  $msg);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to send email. Please try again later.');
        }
    }

    public function userWithJobCreate(Request $request)
    {
        // Validate the common fields
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_num' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Handle identity document if provided
        if ($request->identity_document) {
            $destinationPath = 'storage/app/contractor/';
            $img_front = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->identity_document);
            $image_base64 = base64_decode($img_front);
            $img1 = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img1;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'user',
            'mobile_num' => $request->mobile_num,
            'association' => $request->association,
            'country' => $request->country,
            'state' => $request->state,
            'home_telephone' => $request->home_telephone,
        ]);

        $opportunity = new Opportunity();
        $opportunity->bidUser_id = $user->id; // Link opportunity to the user
        $opportunity->contractor_id = 0;
        $opportunity->opportunity_name = $request->name;
        $opportunity->state = $request->state;
        $opportunity->window_with_name = $request->window_with_name;
        $opportunity->city = $request->city;
        $opportunity->project_type = json_encode($request->company_type);
        $opportunity->est_amount = $request->estimated_amount;
        $opportunity->est_time = $request->date;
        $opportunity->best_time = $request->time;
        $opportunity->detail_description = $request->description;
        $opportunity->purchase_finalize = $request->finalize_by;
        $opportunity->opp_keep_time = $request->keep_open;
        $opportunity->save_bit = $request->submit_bit;
        $opportunity->language = App::currentLocale();

        $opportunity->save();

        // Send email to user and admin
        $recipientEmail = $request->email;
        $adminEmail = 'juanfr@bidinline.com';
        $subject = Lang::get('message.email_subject');
        $adminSubject = 'An user registered and submitted an opportunity.';
        $content = Lang::get('message.email_content.paragraph_1') . '<br>' . Lang::get('message.email_content.paragraph_2') . '<br>' . Lang::get('message.email_content.paragraph_3');
        $adminContent = "An user named {$request->name} registered and submitted an opportunity.";

        try {
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $content) {
                $message->to($recipientEmail)->subject($subject)->setBody($content, 'text/html');
            });
            Mail::send([], [], function ($message) use ($adminEmail, $adminSubject, $adminContent) {
                $message->to($adminEmail)->subject($adminSubject)->setBody($adminContent, 'text/html');
            });

            return redirect()->back()->with('success', __('lang.success_message'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email. Please try again later.');
        }
    }

    public function userWithJobCreateApi(Request $request)
{
    // Validate the common fields
    // $validatedData = $request->validate([
    //     'name' => 'required|string|max:255',
    //     'address' => 'required|string|max:255',
    //     'postal_code' => 'required|string|max:10',
    //     'city' => 'required|string|max:255',
    //     'last_name' => 'required|string|max:255',
    //     'mobile_num' => 'required|string|max:20',
    //     'email' => 'required|email|unique:users,email',
    //     'password' => 'required|string|min:8|confirmed',
    // ]);

    $messages = [
        'detail_description.required' => 'Please provide your requirement.',
        'name.required' => 'Please provide your full name.',
        'country.required' => 'Please provide your country.',
        'state.required' => 'Please provide your province/state.',
        'mobile_num.required' => 'Please provide your telephone.',
        'email.required' => 'Please provide email address.',
    ];

    $validator = Validator::make($request->all(), [
        'detail_description' => 'required',
        'name' => 'required|string|max:255',
        'country' => 'required',
        'state' => 'required',
        'mobile_num' => 'required|max:20',
        'email' => 'required|email|unique:users,email'
       ],$messages);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors()
        ], 422);
    }


    // Handle identity document if provided
    $identityDocumentPath = null;
    if ($request->has('identity_document')) {
        $destinationPath = 'storage/app/contractor/';
        $imgFront = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->identity_document);
        $imageBase64 = base64_decode($imgFront);
        $img1 = time() . '-' . rand(1000, 9999) . '.png';
        $file = $destinationPath . $img1;
        file_put_contents($file, $imageBase64);
        chmod($file, 0755);
        $identityDocumentPath = $file;
    }

    // Create a new user
    try {
        $user = User::create([
            'name' => $request->name,
            // 'last_name' => $request->last_name,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'user',
            'mobile_num' => $request->mobile_num,
            'association' => $request->association,
            'country' => $request->country,
            'state' => $request->state,
            'home_telephone' => $request->home_telephone,
        ]);

        // Create an associated Opportunity
        $opportunity = new Opportunity();
        $opportunity->bidUser_id = $user->id; // Link opportunity to the user
        $opportunity->contractor_id = 0;
        // $opportunity->opportunity_name = $request->opportunity_name;
        $opportunity->state = $request->state;
        // $opportunity->window_with_name = $request->window_with_name;
        $opportunity->city = $request->city;
        // $opportunity->project_type = json_encode($request->company_type);
        // $opportunity->est_amount = $request->estimated_amount;
        $opportunity->est_time = $request->est_time;
        $opportunity->best_time = $request->best_time;
        $opportunity->detail_description = $request->detail_description;
        // $opportunity->purchase_finalize = $request->finalize_by;
        // $opportunity->opp_keep_time = $request->keep_open;
        // $opportunity->save_bit = $request->submit_bit;
        $opportunity->language = App::currentLocale();
        $opportunity->save();

        // Send email to user and admin
        $recipientEmail = $request->email;
        $adminEmail = 'juanfr@bidinline.com';
        $subject = Lang::get('message.email_subject');
        $adminSubject = 'An user registered and submitted an opportunity.';
        $content = Lang::get('message.email_content.paragraph_1') . '<br>' . Lang::get('message.email_content.paragraph_2') . '<br>' . Lang::get('message.email_content.paragraph_3');
        $adminContent = "An user named {$request->name} registered and submitted an opportunity.";

        try {
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $content) {
                $message->to($recipientEmail)->subject($subject)->setBody($content, 'text/html');
            });
            Mail::send([], [], function ($message) use ($adminEmail, $adminSubject, $adminContent) {
                $message->to($adminEmail)->subject($adminSubject)->setBody($adminContent, 'text/html');
            });

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email. Please try again later.'], 500);
        }

        // Return a success response
        return response()->json(['message' => __('lang.success_message')], 201);

    } catch (\Exception $e) {
        // Handle error during user creation or opportunity creation
        return response()->json(['error' => 'Failed to create user and opportunity. Please try again later.'], 500);
    }
}

    
}
