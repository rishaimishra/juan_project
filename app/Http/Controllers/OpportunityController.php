<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Models\Biduser;
use App\Models\Opportunity;
use App\Models\Provincia;
use App\Models\Paise;
use App\Models\Contractor;
use App\Models\User;
use App\Models\Invoice;
use App\Models\CompanyType;
use App\Models\OpportunityMessage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Add this line
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Pdf;
use DB;
use Illuminate\Support\Facades\Log;
use Spatie\Async\Pool;


class OpportunityController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $user_country = $user->country;
        $states = Provincia::where('fk_pais', $user_country)->get();
        $current_language = App::currentLocale();
        $company_type = CompanyType::all();

        return view('opportunity.create', compact('states', 'company_type', 'current_language'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        // return $request;
        $user_id = Auth::user()->id;
        $opportunity = new Opportunity();
        $opportunity->bidUser_id = $user_id;
        $opportunity->contractor_id = 0;
        $opportunity->opportunity_name = $request->name;
        $opportunity->state = $request->state;
        $opportunity->window_with_name = $request->window_with_name;
        $opportunity->city = $request->city;
        $opportunity->project_type = json_encode($request->company_type);
        $opportunity->est_amount = $request->estimated_amount;
        // $opportunity->est_time = $request->date;
        // dd($request->date);
       // Handle date conversion
       if (!empty($request->date)) {
        $opportunity->est_time = Carbon::parse($request->date)->format('Y-m-d\TH:i');
    }

        $opportunity->best_time = $request->time;
        $opportunity->detail_description = $request->description;
        $opportunity->purchase_finalize = $request->finalize_by;
        $opportunity->opp_keep_time = $request->keep_open;
        $opportunity->save_bit = $request->submit_bit;
        $opportunity->language = App::currentLocale();
        // Save the Opportunity instance

        if ($opportunity->save()) {
            // Return success message
            $opportunity_created = Lang::get('lang.opportunity_created');
            return redirect()->route('users-dashboard')->with('success', $opportunity_created);
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function see($id)
    {
        $user = Auth::user();
        $user_country = $user->country;
        $states = Provincia::where('fk_pais', $user_country)->get();

        // Fetch the opportunity and ensure it belongs to the logged-in user
        $opportunity = Opportunity::where('id', $id)
            ->where('bidUser_id', $user->id)
            ->first();

        // If no opportunity is found, redirect back with an error message
        if (!$opportunity) {
            return redirect()->back()->with('error', __('Opportunity not found or access denied.'));
        }

        return view('opportunity.edit', compact('opportunity', 'states'));
    }

    public function see_contractor($id)
    {
        $userEmail = Auth::user()->email;
        $user = Contractor::where('email', $userEmail)->first();
        $states = Provincia::all();
        $opportunity = Opportunity::where('id', $id)->first();
        $already_exists_invoice =
            Invoice::where('opportunity_id', $id)
                ->where('user_id', Auth::user()->id)
                ->first('status') ?? null;

        if ($user && $opportunity) {
            // Decode `company_type` and `project_type`
            $companyTypes = is_string($user->company_type) ? json_decode($user->company_type, true) : (is_array($user->company_type) ? $user->company_type : []);

            $projectTypes = is_string($opportunity->project_type) ? json_decode($opportunity->project_type, true) : (is_array($opportunity->project_type) ? $opportunity->project_type : []);

            // Check for matches
            $matches = array_intersect($companyTypes, $projectTypes);

            if (!empty($matches)) {
                // At least one match found
                return view('contractors.edit', compact('opportunity', 'states', 'already_exists_invoice', 'user'));
            }
        }

        // No match or opportunity not found
        return back()->with('error', 'No match found or opportunity does not exist.');
    }

    public function update(Request $request)
    {
        // return $request;
        // Find the existing Opportunity instance by ID
        $opportunity = Opportunity::where('id', $request->id)->first();
        // return $opportunity;
        // return $request;

        // Check if the opportunity exists
        if (!$opportunity) {
            return back()->with('error', 'Opportunity not found.');
        }

        // Update the Opportunity properties
        $user_id = Auth::user()->id;
        $opportunity->bidUser_id = $user_id;
        $opportunity->contractor_id = 0;
        $opportunity->opportunity_name = $request->name;
        $opportunity->state = $request->state;
        $opportunity->window_with_name = $request->window_with_name;
        $opportunity->city = $request->city;
        $opportunity->project_type = json_encode($request->company_type);
        $opportunity->est_amount = $request->estmiated_amount;
        $opportunity->est_time = $request->date;
        $opportunity->best_time = $request->time;
        $opportunity->detail_description = $request->description;
        $opportunity->purchase_finalize = $request->finalize_by;
        $opportunity->opp_keep_time = $request->keep_open;
        // dd($request->submit_bit);
        $opportunity->save_bit = $request->submit_bit;

        // Save the updated Opportunity instance
        // $opportunity->save();
        if ($opportunity->save()) {
            $opportunity_updated = Lang::get('lang.opportunity_updated');
            return redirect()->route('users-dashboard')->with('success', $opportunity_updated);
        }

        // Return error message if no emails were found
        return back()->with('error', 'No email addresses found to send invitations.');
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
        // Close the cURL session
        curl_close($ch);
    }

    public function admin_opportunity_list()
    {
        // Perform a query to join opportunities with the users table
        $opportunities = DB::table('opportunities')
            ->leftJoin('users', 'opportunities.bidUser_id', '=', 'users.id') // Join with users table based on bidUser_id
            ->leftJoin('provincias', 'opportunities.state', '=', 'provincias.id') // Join with states table
            ->select('opportunities.*', 'users.mobile_num as phone', 'users.email as user_email','users.name as name')
            ->where('opportunities.admin_bit', '!=', 1) // Only fetch opportunities where admin_bit != 1
            ->orderBy('opportunities.id', 'desc') // Order by opportunity ID descending
            ->get();

        return view('opportunity.admin_oppostunity_list', compact('opportunities'));
    }

    public function admin_approve_opp($id)
    {
        try {
            // Fetch the opportunity by ID
            $opportunity = Opportunity::findOrFail($id);
            $opportunity->admin_bit = 2;

            // Decode project_type and state
            $oppProjectType = json_decode($opportunity->project_type, true) ?? [];
            $oppGeoArea = $opportunity->state;

            // Ensure decoded values are arrays (safety check)
            if (!is_array($oppProjectType)) {
                $oppProjectType = [$oppProjectType];
            }

            $emailAddresses = Contractor::where(function ($query) use ($oppProjectType) {
                // Existing where clause logic for $oppProjectType (company type)
                if (is_array($oppProjectType)) {
                    $query->where(function ($q) use ($oppProjectType) {
                        foreach ($oppProjectType as $type) {
                            $q->orWhereJsonContains('company_type', $type);
                        }
                    });
                } else {
                    $query->whereJsonContains('company_type', $oppProjectType);
                }
            })
                ->get()
                ->filter(function ($contractor) use ($oppGeoArea) {
                    $contractorGeoArea = json_decode($contractor->geographic_area, true);

                    // Handle cases where $contractorGeoArea might be null or not an array after decoding
                    if (!is_array($contractorGeoArea)) {
                        return false; // Skip if geographic_area is not a valid array
                    }

                    // $oppGeoArea is a single value, $contractorGeoArea is an array
                    return in_array($oppGeoArea, $contractorGeoArea); // Direct ID comparison
                })
                ->pluck('email');

            Log::debug("Email Addresses (after filtering): ", $emailAddresses->toArray() ?? []); // Correct: Empty array if collection is null or empty. Use toArray() to convert Collection to array.



            if ($emailAddresses->isEmpty()) {
                return redirect()->back()->with('error', 'No contractors match the criteria.');
            }
            // Set application locale for email content
            App::setLocale($opportunity->language);

            $oppo_name = $opportunity->opportunity_name;
            $text_email_saludo = Lang::get('message.dear_user');
            // $text_cliente = 'Customer'; // You may want to customize this per recipient
            $text_email_despedida_1 = Lang::get('message.best_regards');
            $text_email_despedida_2 = Lang::get('message.bidline_admin');

            $text_email_aviso = Lang::get('message.email_content.opportunity_create_email_text1');
            $text_email_asunto_invitacion_oct = Lang::get('message.email_content.opportunity_create_email_text2');
            $text_email_contenido_invitacion_oc_1 = Lang::get('message.email_content.opportunity_create_email_text3');
            $text_email_contenido_invitacion_oct_12 = Lang::get('message.email_content.opportunity_create_email_text4');
            $loginUrl = config('app.contractor_login_url');


            $emailContent = $text_email_saludo . "\n\n" . $oppo_name . "\n\n" . $text_email_contenido_invitacion_oc_1 . ' ' . $text_email_contenido_invitacion_oct_12 . "\n\n" . $loginUrl . "\n\n" . $text_email_aviso . "\n\n" . $text_email_despedida_1 . "\n" . $text_email_despedida_2;

            // $emailAddresses = ['rishavbeas@gmail.com', 'rishimishra7872@gmail.com', 'matheletes111@gmail.com'];

            // foreach ($emailAddresses as $email) {
            SendEmailJob::dispatch($emailAddresses, $loginUrl, $emailContent, $text_email_asunto_invitacion_oct); // Dispatch the job
            // }

            $user_id = $opportunity->bidUser_id;
            $user_email = User::where('id', $user_id)->first();
            $useremailget = $user_email->email;
            $text_email_contenido_invitacion_for_user = Lang::get('message.email_content.opportunity_email_for_user');
            $emailContent_user = $text_email_saludo . "\n\n" . $oppo_name . " " . $text_email_contenido_invitacion_for_user;
            $text_email_asunto_invitacion_useremail = Lang::get('message.email_content.opportunity_create_email_text3_for_user');

            Mail::send([], [], function ($message) use ($useremailget, $text_email_asunto_invitacion_useremail, $emailContent_user) {
                $message->to($useremailget)->subject($text_email_asunto_invitacion_useremail)->setBody($emailContent_user, 'text/plain'); // Set content as plain text
            });
            // Save changes to the opportunity
            $opportunity->save();


            return redirect()->back()->with('success', 'Opportunity approved successfully, and notifications sent.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Opportunity not found.');
        } catch (Exception $e) {
            Log::error('Error approving opportunity: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while approving the opportunity.');
        }
    }

    public function admin_reject_opp($id)
    {
        $opportunities = Opportunity::where('id', $id)->first();
        $opportunities->admin_bit = 1;
        $opportunities->save();
        return redirect()->back()->with('success', 'Opportunity rejected successfully.');
    }

    public function admin_edit_opportunity($id)
    {
        $states = Provincia::all();
        $opportunity = Opportunity::where('id', $id)->first();
        return view('admin.opportunity_edit', compact('opportunity', 'states'));
    }

    public function admin_update_opportunity(Request $request)
    {
        // return $request;
        // Find the existing Opportunity instance by ID
        $opportunity = Opportunity::where('id', $request->id)->first();

        // Check if the opportunity exists
        if (!$opportunity) {
            return back()->with('error', 'Opportunity not found.');
        }

        // Update the Opportunity properties
        // $user_id = Auth::user()->id;
        // $opportunity->bidUser_id = $user_id;
        // $opportunity->contractor_id = 0;
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
        // $opportunity->save_bit = $request->submit_bit;
        // $opportunity->admin_bit = $request->admin_bit;

        // Save the updated Opportunity instance
        $opportunity->save();
        return redirect()->route('getadminopp')->with('success', 'Opportunity updated successfully.');
    }
    public function reject_opportunity($id)
    {
        // return $id;
        return redirect()->route('users-dashboard')->with('success', 'Bidinproject thanks for effort and attention');
    }

    public function invoice_generate($id)
    {
        $user = Auth::user();
        $opportunity = Opportunity::findOrFail($id); // Replace Opportunity with your actual model.
        $states = Provincia::where('id', $user->state)->first('nombre');
        $country = Paise::where('id', $user->country)->first('nombre');
        $already_exists_invoice = Invoice::where('opportunity_id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($already_exists_invoice) {
            $message_send_successfully = Lang::get('lang.invoice_already_generated');
            return redirect()->route('users-dashboard')->with('success', $message_send_successfully);
        }

        // $check_unpaid_invoice = Invoice::where('user_id', Auth::user()->id)
        //     ->where('status', 'unpaid')
        //     ->first();
        // if ($check_unpaid_invoice) {
        //     $message_send_successfully = Lang::get('lang.invoice_unpaid_message');
        //     return redirect()->route('users-dashboard')->with('success', $message_send_successfully);
        // }

        // Generate Invoice Number
       // Get the current year
    $currentYear = date('Y');

    // Get the invoice count for the current year for the user
    $invoiceCount = Invoice::whereYear('created_at', $currentYear)
        ->count() + 1; // Increment to get next number

    // Generate Invoice Number
    $invoiceNumber = $invoiceCount . '-' . $currentYear;
        // Fetch the response from the database
        // $response = Invoice::where('user_id', Auth::user()->id)->value('response');
        $response = Invoice::where('user_id', Auth::user()->id)
            ->where('opportunity_id', $id)
            ->value('response');

        // Decode the JSON response
        $responseData = json_decode($response, true);

        // Access the country_code
        $countryCode = $responseData['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? null;

        // Get the amount from the query parameter
        $amount = request('amount');


        $language_sign = App::getLocale();


        if ($opportunity->est_amount == 1) {
            // $pay_amount = 10;
            $pay_amount = 3;
        } elseif ($opportunity->est_amount == 2) {
            $pay_amount = 15;
        } elseif ($opportunity->est_amount == 3) {
            $pay_amount = 20;
        } else {
            $pay_amount = 0;
        }
        // Create Invoice Data
        $data = [
            'lang_sign' => $language_sign,
            'invoice_id' => $invoiceNumber,
            'date' => now()->format('Y-m-d'),
            'user' => $user,
            'opportunity' => $opportunity,
            'subtotal' => $pay_amount, // Use the dynamic pay_amount
            'tax_rate' => 21, // 21%
            'tax' => $pay_amount * 0.21,
            'total' => $pay_amount * 1.21,
            'country_code' => $countryCode,
            'states' => $states,
            'country' => $country,
        ];
        // dd($opportunity->id);

        // Load the Blade View with Data
        // return view('opportunity/invoice', $data);
        $pdf = Pdf::loadView('opportunity/invoice', $data);

            // Define the base invoices directory
        $baseDirectory = public_path('invoices');


        // Generate the full file path
        $fileName ='invoices/' .$invoiceNumber. '.pdf';

       
        $pdf->save(public_path($fileName));

        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;
        $invoice->opportunity_id = $id;
        $invoice->invoice_path = $fileName;
        if ($opportunity->est_amount == 1) {
            $invoice->amount = 10;
        }
        if ($opportunity->est_amount == 2) {
            // $invoice->amount = 20;
            $invoice->amount = 15;
        }
        if ($opportunity->est_amount == 3) {
            // $invoice->amount = 30;
            $invoice->amount = 20;
        }
        $invoice->save();
        $pdf->download($fileName);
        $message_send_successfully = Lang::get('lang.invoice_generated_message');
        return redirect()->route('invoice-list')->with('success', $message_send_successfully);
    }


    public function chat_opportunity($id)
    {
        // return $id;
        $opp = Opportunity::where('id', $id)->first();
        if ($opp->save_bit == 0) {
            $opportunity_not_paid = Lang::get('lang.opportunity_not_published');
            return redirect()->route('users-dashboard')->with('success', $opportunity_not_paid);
        }
        $checkOpp = Invoice::where('opportunity_id', $id)->first();
        if (!$checkOpp) {
            $opportunity_not_paid = Lang::get('lang.opportunity_not_paid');
            return redirect()->route('users-dashboard')->with('success', $opportunity_not_paid);
        } else {
            $getOpp = Invoice::with('user')->where('opportunity_id', $id)->where('status', 'paid')->get();
            $oppname = Opportunity::select('opportunity_name')->where('id', $id)->first();
            // dd($oppname->opportunity_name);
            return view('invoice.chat_room', compact('getOpp', 'oppname'));
        }
    }

    // public function message_opportunity($id, $oppId)
    // {
    //     // return $id;
    //     $checkOpp = Invoice::where('id', $id)->where('opportunity_id', $oppId)->first();
    //     // return $checkOpp;
    //     if (!$checkOpp) {
    //         $opportunity_not_paid = Lang::get('lang.opportunity_not_paid');
    //         return redirect()->route('users-dashboard')->with('success', $opportunity_not_paid);
    //     } else {
    //         $getOpp = OpportunityMessage::where('invoice_id', $id)->where('opportunity_id', $oppId)->orderBy('created_at', 'asc')->get();
    //         $oppname = Opportunity::select('opportunity_name')->where('id', $oppId)->first();

    //         return view('invoice.chat_room_message', compact('getOpp', 'id', 'oppId', 'oppname'));
    //     }
    // }

    public function message_opportunity(Request $request, $id, $oppId)
    {
        if ($request->ajax()) {
            // Fetch messages dynamically via AJAX
            $messages = OpportunityMessage::where('invoice_id', $id)
                ->where('opportunity_id', $oppId)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'messages' => $messages,
            ]);
        }

        // Check if invoice is valid for the opportunity
        $checkOpp = Invoice::where('id', $id)->where('opportunity_id', $oppId)->first();

        if (!$checkOpp) {
            return redirect()->route('users-dashboard')
                ->with('success', Lang::get('lang.opportunity_not_paid'));
        }

        // Fetch messages and opportunity name for the view
        $getOpp = OpportunityMessage::where('invoice_id', $id)
            ->where('opportunity_id', $oppId)
            ->orderBy('created_at', 'asc')
            ->get();

        $oppname = Opportunity::select('opportunity_name')
            ->where('id', $oppId)
            ->first();

        return view('invoice.chat_room_message', compact('getOpp', 'id', 'oppId', 'oppname'));
    }

    // public function contractor_message_opportunity($id, $oppId)
    // {
    //     // return $id;
    //     $checkOpp = Invoice::where('id', $id)->where('opportunity_id', $oppId)->first();
    //     // return $checkOpp;
    //     if (!$checkOpp) {
    //         $opportunity_not_paid = Lang::get('lang.opportunity_not_paid');
    //         return redirect()->back()->with('success', $opportunity_not_paid);
    //     } else {
    //         $getOpp = OpportunityMessage::where('invoice_id', $id)
    //             ->where('reciever_id', Auth::user()->id)
    //             ->where('opportunity_id', $oppId)
    //             ->orderBy('created_at', 'asc')
    //             ->get();
    //         $oppname = Opportunity::select('opportunity_name')->where('id', $oppId)->first();

    //         return view('invoice.chat_room_message_contractor', compact('getOpp', 'id', 'oppId', 'oppname'));
    //     }
    // }

    public function contractor_message_opportunity($id, $oppId)
    {
        // Check if the invoice exists and is linked to the opportunity
        $checkOpp = Invoice::where('id', $id)
            ->where('opportunity_id', $oppId)
            ->first();

        if (!$checkOpp) {
            return redirect()->back()->with('error', Lang::get('lang.opportunity_not_paid'));
        }

        // Fetch messages related to the invoice and opportunity
        $getOpp = OpportunityMessage::where('invoice_id', $id)
            ->where(function ($query) {
                $query->where('reciever_id', Auth::id())
                    ->orWhere('sender_id', Auth::id()); // Include messages sent by the user
            })
            ->where('opportunity_id', $oppId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Fetch the opportunity name
        // $oppname = Opportunity::where('id', $oppId)->value('opportunity_name');
        $oppname = Opportunity::select('opportunity_name')->where('id', $oppId)->first();


        // Return JSON response for AJAX calls
        if (request()->ajax()) {
            return response()->json(['messages' => $getOpp]);
        }

        return view('invoice.chat_room_message_contractor', compact('getOpp', 'id', 'oppId', 'oppname'));
    }


    public function send_message(Request $request)
    {
        // return $request;
        $checkOpp = Invoice::where('id', $request->invoice_id)
            ->where('opportunity_id', $request->oppId)
            ->first();
        if ($checkOpp) {
            $imagePaths = [];
            if ($request->hasFile('chat_images')) {
                foreach ($request->file('chat_images') as $image) {
                    // Save each image in the 'uploads/chat_images' directory
                    $path = $image->store('uploads/chat_images', 'public');
                    $imagePaths[] = $path;
                }
            }
            $images = !empty($imagePaths) ? implode(',', $imagePaths) : null;
            OpportunityMessage::create([
                'sender_id' => Auth::user()->id,
                'invoice_id' => $request->invoice_id,
                'opportunity_id' => $request->oppId,
                'reciever_id' => $checkOpp->user_id,
                'message' => $request->messageText,
                'image' => $images,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $message_send_successfully = Lang::get('lang.message_send_successfully');
            return redirect()->back()->with('success', $message_send_successfully);
        }
    }
    public function send_message_contractor(Request $request)
    {
        
        // return $request;
        $checkOpp = Invoice::where('id', $request->invoice_id)
            ->where('opportunity_id', $request->oppId)
            ->first();
        if ($checkOpp) {
            $imagePaths = [];
            if ($request->hasFile('chat_images')) {
                foreach ($request->file('chat_images') as $image) {
                    if (!$image->isValid()) {
                        return back()->withErrors(['error' => 'File upload error: ' . $image->getErrorMessage()]);
                    }
                    // Save each image in the 'uploads/chat_images' directory
                    $path = $image->store('uploads/chat_images', 'public');
                    $imagePaths[] = $path;
                }
            }
            $images = !empty($imagePaths) ? implode(',', $imagePaths) : null;
            OpportunityMessage::create([
                'sender_id' => Auth::user()->id,
                'invoice_id' => $request->invoice_id,
                'opportunity_id' => $request->oppId,
                'reciever_id' => $checkOpp->user_id,
                'message' => $request->messageText,
                'image' => $images,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $message_send_successfully = Lang::get('lang.message_send_successfully');
            return redirect()->back()->with('success', $message_send_successfully);
        }
    }

    public function show_opportunity_contractors($id)
    {
        // return $id;
        $contractors = Invoice::where('opportunity_id', $id)
            ->with(['user', 'opportunity'])
            ->get();
        return view('opportunity.admin_opportunity_contractor', compact('contractors'));
    }

    public function admin_contractor_message_show($oppId, $con_id)
    {
        // return $con_id;
        $contractor_id = $con_id;
        $getOpp = OpportunityMessage::where('opportunity_id', $oppId)->where('reciever_id', $con_id)->orderBy('created_at', 'asc')->get();
        return view('invoice.admin_contractor_message', compact('getOpp', 'contractor_id'));
    }
}
