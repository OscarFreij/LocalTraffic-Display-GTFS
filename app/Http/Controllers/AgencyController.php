<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if($request->filled('q'))
        {
            $agencies = Agency::search($request->q)->simplePaginate(20);
        }
        else
        {
            $agencies = Agency::orderBy('agency_name')->simplePaginate(20);
        }

        
        return view('agency.index' , [
            'agencies' => $agencies
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $agency = Agency::where('agency_id', '=', $id)->firstOrFail();

        
        return view('agency.show' , [
            'agency' => $agency
        ]);
    }
}
