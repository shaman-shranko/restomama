<?php

namespace App\Http\Controllers\Admin;

use App\Events;
use App\Galleries;
use App\GalleryLangs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventGalleryController extends Controller
{
    /**
     * EventGalleryController construct
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $event = Events::with(['langs', 'restaurant'])->findOrFail($id);
        $event_langs = array();

        foreach ($event->langs as $lang){
            $event_langs[$lang->lang]['name']           = $lang->name;
        }
        foreach ($event->restaurant->langs as $lang){
            $event_langs[$lang->lang]['restaurant']     = $lang->heading;
        }

        $data['event']       = $event;
        $data['event_langs'] = $event_langs;

        return view('admin.event_gallery.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate(array(
            'name.*' => 'required|string',
        ));

        $event = Events::with('langs')->findOrFail($id);

        $event_gallery = new Galleries();
        $event_gallery->type = 'event_gallery';
        $event_gallery->save();

        foreach (config('app.locales') as $locale){
            $lang = new GalleryLangs();
            $lang->lang = $locale;
            $lang->name = $request->name[$locale];
            $event_gallery->langs()->save($lang);
        }

        $event->galleries()->save($event_gallery);

        return redirect()->route('event_gallery.edit', ['id' => $event_gallery->id]);
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
        $gallery = Galleries::with(['langs', 'event'])->findOrFail($id);

        $event_langs = array();

        foreach($gallery->langs as $lang){
            $event_langs[$lang->lang]['gallery'] = $lang->name;
        }
        foreach($gallery->event as $event){
            $data['event'] = $event;
            foreach ($event->langs as $lang){
                $event_langs[$lang->lang]['name']    = $lang->name;
            }
            foreach($event->restaurant->langs as $lang){
                $event_langs[$lang->lang]['restaurant'] = $lang->heading;
            }
        }

        $items_langs = array();
        foreach($gallery->items() as $item){
            foreach ($item->langs as $lang){
                $items_langs[$item->id][$lang->lang]['title']    = $lang->title;
                $items_langs[$item->id][$lang->lang]['subtitle'] = $lang->subtitle;
            }
        }

        $data['event_langs'] = $event_langs;
        $data['items']       = $gallery->items()->get();
        $data['gallery']     = $gallery;
        $data['items_langs'] = $items_langs;

        return view('admin.event_gallery.form', $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
