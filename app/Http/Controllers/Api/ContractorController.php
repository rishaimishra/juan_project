<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Contractor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Paise; // Model for paises
use App\Models\Provincia; // Model for provincias

class ContractorController extends Controller
{
    public function add_contractor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:contractors,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $imagePath = null;
        if ($request->hasFile('identity_document')) {
            $imagePath = $request->file('identity_document')->store('identity_documents', 'public');
        }
        $contractor = Contractor::create([
            'company_name' => $request->company_name,
            'tin' => $request->tax_identification_number,
            'license_num' => $request->license_number,
            'insurance_num' => $request->insurance_number,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'country' => $request->country,
            'state' => $request->state,
            'representative_name' => $request->name,
            'last_name' => $request->last_name,
            'company_telephone' => $request->company_telephone,
            'mobile_num' => $request->mobile_telephone,
            'position' => $request->position,
            'company_type' => json_encode($request->company_type),
            'geographic_area' => $request->geo_graphical_area,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'states' => json_encode($request->states),
            'countries' => json_encode($request->countries),
            'identity_document' => $imagePath,
        ]);

        return response()->json(['message' => 'Contractor registered successfully', 'contractor' => $contractor], 200);
    }

    //  public function call_file(Request $request)
    // {
    //     // Set POST parameters
    //     $data = [
    //         'lng' => $request->lng,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'name' => $request->name,
    //         'dni' => $request->dni,
    //         'company_number' => $request->company_number,
    //         'mobile_number' => $request->mobile_number,
    //         'position' => $request->position,
    //         'lastname' => $request->lastname,
    //     ];

    //     // Log the data being sent
    //     Log::info('Data sent to API:', $data);

    //     // Initialize cURL session
    //     $ch = curl_init();

    //     // Set cURL options
    //     curl_setopt($ch, CURLOPT_URL, 'https://www.bidinline.com/name.php'); // Replace with your API endpoint
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Send data as a URL-encoded string
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

    //     // Set headers if needed (e.g., Content-Type, Authorization)
    //     $headers = ['Content-Type: application/x-www-form-urlencoded'];
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //     // Execute the request
    //     $response = curl_exec($ch);

    //     // Check for errors
    //     if (curl_errno($ch)) {
    //         $error = curl_error($ch);
    //         Log::error('cURL error:', ['error' => $error]);
    //         echo 'Error: ' . $error;
    //     } else {
    //         // Log the response
    //         Log::info('API response:', ['response' => $response]);
    //         echo $response;
    //     }

    //     // Close the cURL session
    //     curl_close($ch);
    // } 



public function call_file(Request $request)
{
    $data = [
        'lng' => $request->lng,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'name' => $request->name,
        'dni' => $request->dni,
        'company_number' => $request->company_number,
        'mobile_number' => $request->mobile_number,
        'position' => $request->position,
        'lastname' => $request->lastname,
    ];

    try {
        Log::info('Data sent to API:', $data);

        $response = Http::asForm() // Sends data as `application/x-www-form-urlencoded`
            ->post('https://www.bidinline.com/name.php', $data);

        if ($response->successful()) {
            Log::info('API response:', ['response' => $response->body()]);
            return $response->body();
        } else {
            Log::error('API call failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return response()->json([
                'error' => 'API call failed',
                'details' => $response->body(),
            ], $response->status());
        }
    } catch (\Exception $e) {
        Log::error('Exception during API call:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Internal server error'], 500);
    }
}

public function getPaises()
    {
        try {
            $paises = Paise::select('id', 'nombre', 'cod', 'moneda', 'activo')->where('borrado', 0)->get();

            return response()->json([
                'message' => 'Countries fetched successfully.',
                'data' => $paises,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching countries.'], 500);
        }
    }

    public function getProvincias($id)
    {
        try {
            $provincias = Provincia::with('pais:id,nombre') // Load related country (paises)
                ->select('id', 'fk_pais', 'nombre', 'cod', 'activo')
                ->where('fk_pais', $id)
                ->get();

            return response()->json([
                'message' => 'Provinces fetched successfully.',
                'data' => $provincias,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching provinces.'], 500);
        }
    }

}
