<?php

namespace App\Http\Controllers;

use App\Models\Screen;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreScreenRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateScreenRequest;

class ScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->integer('limit', default: 10);
        $screens = Screen::filterByQueryString()->paginate($limit)->withQueryString();
        return view('screens.index', [
            'screens' => $screens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('screens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScreenRequest $request)
    {
        $newScreen = new Screen();
        $newScreen->short_name = Str::uuid();
        $newScreen->long_name = $request->long_name;
        $newScreen->description = $request->description;
        $newScreen->longitude = $request->longitude;
        $newScreen->latitude = $request->latitude;
        $newScreen->timezone = $request->timezone;
        $newScreen->stop_queue = json_decode($request->stop_queue);
        $newScreen->user_id = Auth::user()->id;
        $newScreen->save();

        return to_route('screens.show', ['screen_id' => $newScreen->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Int $screen_id)
    {
        $screen = Screen::FindOrFail($screen_id);
        return view('screens.show', ['screen' => $screen]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Int $screen_id)
    {
        $screen = Screen::FindOrFail($screen_id);
        return view('screens.edit', ['screen' => $screen]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScreenRequest $request, Int $screen_id)
    {
        $screen = Screen::FindOrFail($screen_id);
        $screen->long_name = $request->long_name;
        $screen->description = $request->description;
        $screen->longitude = $request->longitude;
        $screen->latitude = $request->latitude;
        $screen->timezone = $request->timezone;
        $screen->stop_queue = json_decode($request->stop_queue);
        $screen->save();

        return to_route('screens.show', ['screen_id' => $screen->id])->with('status', 'screen-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Int $screen_id): RedirectResponse
    {
        $screen = Screen::find($screen_id);

        $request->request->add(['long_name' => $screen->long_name]);

        $messages = [
            'screenName.required' => 'Missing screen name',
            'screenName.same' => 'Incorrect screen name',
        ];
        $rules = [
            'screenName' => [
                'required',
                'string',
                "same:long_name"
            ]
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'screenDeletion')->withInput();
        }
        $screen->delete();
        return Redirect::route('screens.index')->with('status', 'screen-deleted');
    }
}
