<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biduser;
use App\Models\User;
use App\Models\Opportunity;
use App\Models\Contractor;
use App\Models\Invoice;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash; // Add this line
use Illuminate\Support\Facades\Mail; // Add this line
use Illuminate\Support\Facades\App;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function list()
    {
        $user_id = Auth::user()->id;
        $invoices = Invoice::where('user_id', $user_id)->with('opportunity')->get();

        $todayMessages = DB::table('opportunity_messages')
        ->whereDate('created_at', Carbon::today())
        ->where('reciever_id',$user_id)
        // ->select('sender_id', 'message', 'created_at')
        ->get();
        return view('invoice.list', compact('invoices','todayMessages'));
    }

    public function get_invoice()
    {
        $invoices = Invoice::with('opportunity')->with('user')->get();
        return view('invoice.get_invoice', compact('invoices'));
    }

    public function createPayment(Request $request, $amount)
    {
        try {
            $invoice = Invoice::findOrFail($request->id);

            if ($invoice->status === 'paid') {
                return redirect()->route('invoice-list')->with('success', 'Invoice already paid.');
            }

            $provider = \PayPal::setProvider();
            $provider->setApiCredentials(config('paypal'));

            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'EUR',
                            'value' => $amount, // Use dynamic amount
                        ],
                    ],
                ],
                'application_context' => [
                    'return_url' => route('paypal.success', ['id' => $invoice->id]),
                    'cancel_url' => route('invoice-list'),
                ],
            ]);

            if (isset($response['id'])) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            \Log::error('PayPal payment creation failed: ' . json_encode($response));
            return redirect()->route('invoice-list')->with('error', 'Payment creation failed.');
        } catch (\Exception $e) {
            \Log::error('Error during payment creation: ' . $e->getMessage());
            return redirect()->route('invoice-list')->with('error', 'An error occurred while creating the payment.');
        }
    }

    public function success(Request $request)
    {
        try {
            $paypal = new PayPalClient();
            $paypal->setApiCredentials(config('paypal'));
            $paypalToken = $paypal->getAccessToken();

            $response = $paypal->capturePaymentOrder($request->query('token'));

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $invoice = Invoice::findOrFail($request->id);

                // Update the invoice
                $invoice->response = json_encode($response);
                $invoice->status = 'paid';
                $invoice->save();

                return redirect()->route('invoice-list')->with('success', 'Invoice paid successfully.');
            }

            \Log::warning('Payment not completed: ' . json_encode($response));
            return redirect()->route('invoice-list')->with('error', 'Payment was not completed.');
        } catch (\Exception $e) {
            \Log::error('Error during payment capture: ' . $e->getMessage());
            return redirect()->route('invoice-list')->with('error', 'An error occurred while capturing the payment.');
        }
    }

    public function Cardsuccess(Request $request, $id)
    {
        try {
            if (isset($id)) {
                $invoice = Invoice::findOrFail($id);

                // Update the invoice
                $invoice->status = 'paid';
                $invoice->save();

                return redirect()->route('invoice-list')->with('success', 'Invoice paid successfully.');
            }

            \Log::warning('Payment not completed: ' . json_encode($response));
            return redirect()->route('invoice-list')->with('error', 'Payment was not completed.');
        } catch (\Exception $e) {
            \Log::error('Error during payment capture: ' . $e->getMessage());
            return redirect()->route('invoice-list')->with('error', 'An error occurred while capturing the payment.');
        }
    }

    public function cancel()
    {
        return view('payment.cancel')->with('error', 'Payment was canceled.');
    }

    // public function createCardPayment(Request $request, $amount)
    // {
    //     return $request->id;
    //     return $request;
    //     return 'saf';
    // }

    public function generateHash(Request $request)
    {
        $abc = $request->all();
        \Log::info($abc);

        $encryptin = '1WPALZKM';
        $merchant_id = $request->input('merchant_id');
        $AcquirerBIN = $request->input('AcquirerBIN');
        $TerminalID = $request->input('TerminalID');
        $Num_operacion = $request->input('Num_operacion');
        $Importe = $request->input('Importe');
        $TipoMoneda = $request->input('TipoMoneda');
        $Exponente = $request->input('Exponente');
        $Cifrado = $request->input('Cifrado');
        $URL_OK = $request->input('URL_OK');
        $URL_NOK = $request->input('URL_NOK');

        $password = $encryptin . $merchant_id . $AcquirerBIN . $TerminalID . $Num_operacion . $Importe . $TipoMoneda . $Exponente . $Cifrado . $URL_OK . $URL_NOK;
        \Log::info("Hash Input: $password");

        $hash = hash('sha256', $password);
        \Log::info("Generated Hash: $hash");

        return response()->json(['hash' => $hash]);
    }
}
