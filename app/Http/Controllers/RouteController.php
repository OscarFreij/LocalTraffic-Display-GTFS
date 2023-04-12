<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if($request->filled('q'))
        {
            $routes = Route::search($request->q)->orderBy('route_id', 'asc')->simplePaginate(20);
        }
        else
        {
            $routes = Route::orderBy('route_id', 'asc')->simplePaginate(20);
        }

        return view('route.index' , [
            'routes' => $routes
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $route = Route::where('route_id', '=', $id)->firstOrFail();
        $trips = $route->trip()->simplePaginate();
        
        return view('route.show' , [
            'route' => $route,
            'trips' => $trips
        ]);
    }
}
