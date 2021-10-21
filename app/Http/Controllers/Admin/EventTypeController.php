<?php

namespace App\Http\Controllers\Admin;

use App\EventsTypes;
use App\EventsTypesLangs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventTypeController extends Controller
{
    /**
     * EventTypeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-restaurants');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['types'] = EventsTypes::with('langs')->get();
        return view('admin.event_types.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event_types.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(array(
            'lang.*.name'   => 'required|string',
            'sorting'       => 'required|integer',
        ));

        $type = new EventsTypes();
        $type->sorting = $request->sorting;
        $type->active  = $request->active == "on";
        $type->save();

        foreach (config('app.locales') as $lang){
            $type_lang = new EventsTypesLangs();
            $type_lang->lang = $lang;
            $type_lang->name = $request->lang[$lang]['name'];
            $type->langs()->save($type_lang);
        }

        return redirect()->route('event_types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = EventsTypes::with('langs')->findOrFail($id);
        $type_langs = [];
        foreach($type->langs as $lang){
            $type_langs[$lang->lang]['name'] = $lang->name;
        }
        $data['type'] = $type;
        $data['type_langs'] = $type_langs;

        return view('admin.event_types.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(array(
            'lang.*.name'   => 'required|string',
            'sorting'       => 'required|integer',
        ));

        $type = EventsTypes::with('langs')->findOrFail($id);
        $type->sorting = $request->sorting;
        $type->active  = $request->active == "on";
        $type->save();

        foreach($type->langs as $lang){
            $lang->name = $request->lang[$lang->lang]['name'];
            $lang->save();
        }

        return redirect()->route('event_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = EventsTypes::findOrFail($id);
        $type->langs()->delete();
        $type->delete();
        return redirect()->route('event_types.index');
    }
}
