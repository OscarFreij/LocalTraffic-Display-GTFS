<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use Illuminate\Http\Request;

class StopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $limit = $request->integer('limit', default: 10);
        $stops = Stop::filterByQueryString()->paginate($limit)->withQueryString();
        return view('data.stops.index', [
            'stops' => $stops,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Int $stop_id)
    {
        //
        $stop = Stop::findOrFail($stop_id);
        return view('data.stops.show', [
            'stop' => $stop,
        ]);
    } 
}
