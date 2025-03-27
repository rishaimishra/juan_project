<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contractors = Contractor::with(['countryContractor', 'stateContractor'])
                                ->orderByDesc('id')
                                ->get();
    
        return view('contractor_dashboard', compact('contractors'));
    }
    

    public function delete_contractor($id){
        // return $id;
         $contractor = Contractor::where('id',$id)->first();
         $contractor_user = User::where('email',$contractor->email)->first();
         $contractor->delete();
         if ($contractor_user) {
            $contractor_user->delete();
         }
        return back()->with('success','Contractor deleted successfully');
    }
}
