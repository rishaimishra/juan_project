<?php
namespace App\Http\Controllers\Api;
use App\Models\Leads;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $lead = Leads::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Lead created successfully',
            'data' => $lead,
        ], 201);
    }
}
