<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biduser;
use App\Models\User;
use App\Models\Opportunity;
use App\Models\Contractor;
use App\Models\Invoice;
use App\Models\Leads;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash; // Add this line
use Illuminate\Support\Facades\Mail; // Add this line
use Illuminate\Support\Facades\App;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class LeadsController extends Controller
{
    public function index()
    {
        $leads = Leads::orderByDesc('id')->get();

        return view('Leads.index', compact('leads'));
    }

}