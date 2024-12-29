<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\StopTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $limit = $request->integer('limit', default: 10);
        $routes = Route::filterByQueryString()->paginate($limit)->withQueryString();
        return view('data.routes.index', [
            'routes' => $routes,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Int $route_id, Request $request)
    {
        //
        $route = Route::findOrFail($route_id);       
        return view('data.routes.show', [
            'route' => $route,
        ]);
    } 
}
