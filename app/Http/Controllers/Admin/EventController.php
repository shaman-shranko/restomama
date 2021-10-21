<?php

namespace App\Http\Controllers\Admin;

use App\Events;
use App\EventsLangs;
use App\EventsTypes;
use App\Http\Controllers\Admin\ImageController as ImageController;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * EventController constructor.
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
        $data['events'] = Events::with(['langs', 'type', 'restaurant'])->get();

        return view('admin.events.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['types'] = EventsTypes::where('active', '=', true)->with('langs')->get();
        $data['restaurants'] = Restaurant::with('langs')->get();

        return view('admin.events.form', $data);
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
            'uri'               => 'required|unique:events|regex:/^[a-z_0-9\.-]+$/i',
            'langs.*.name'      => 'required|string',
            'langs.*.heading'   => 'required|string',
            'langs.*.seo_title' => 'required|string',
            'price'             => 'required|integer',
            'image'             => 'nullable|image|dimensions:max_width=2400,max_height=1350',
            'type'              => 'required|integer|exists:events_types,id',
            'restaurant'        => 'required|integer|exists:restaurants,id',
        ));

        $event = new Events();

        $event->uri             = $request->uri;
        $event->sorting         = isset($request->sorting) ? $request->sorting : 10;
        $event->active          = $request->is_active == "on";
        $event->price           = $request->price;
        $event->event_type_id   = $request->type;
        $event->restaurant_id   = $request->restaurant;

        $event->save();

        $u_image = $request->file('image');
        if(isset($u_image)){
            $image = ImageController::imageUpload($u_image, 'uploads/events_thumbs/'.$event->id.'/');
            ImageController::imageResize($image, config('image.sizes.card'));
            $event->image_id = $image->id;
        }

        $event->save();

        foreach($request->lang as $key => $lang){
            $save_lang = new EventsLangs();

            $save_lang->lang            = $key;
            $save_lang->name            = $lang['name'];
            $save_lang->heading         = $lang['heading'];
            $save_lang->seo_title       = $lang['seo_title'];
            $save_lang->seo_description = $lang['seo_description'];
            $save_lang->seo_text        = $lang['seo_text'];

            $event->langs()->save($save_lang);
        }

        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Events::with(['langs', 'restaurant', 'type', 'image', 'galleries'])->findOrFail($id);

        $event_langs = array();
        foreach($event->langs as $lang){
            $event_langs[$lang->lang]['name']            = $lang->name;
            $event_langs[$lang->lang]['heading']         = $lang->heading;
            $event_langs[$lang->lang]['seo_title']       = $lang->seo_title;
            $event_langs[$lang->lang]['seo_description'] = $lang->seo_description;
            $event_langs[$lang->lang]['seo_text']        = $lang->seo_text;
        }
        foreach($event->type->langs as $lang){
            $event_langs[$lang->lang]['type']            = $lang->name;
        }
        foreach($event->restaurant->langs as $lang){
            $event_langs[$lang->lang]['restaurant']      = $lang->heading;
        }
        $data['event']       = $event;
        $data['event_langs'] = $event_langs;

        $galleries_langs = array();
        foreach($event->galleries as $gallery){
            foreach ($gallery->langs as $lang){
                $galleries_langs[$gallery->id][$lang->lang]['name'] = $lang->name;
            }
        }

        $data['galleries_langs'] = $galleries_langs;

        return view('admin.events.info', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['event'] = Events::with(['langs'])->findOrFail($id);
        $data['types'] = EventsTypes::where('active', '=', true)->with('langs')->get();
        $data['restaurants'] = Restaurant::with('langs')->get();

        $event_langs = array();
        foreach($data['event']->langs as $lang){
            $event_langs[$lang->lang]['name']                   = $lang->name;
            $event_langs[$lang->lang]['heading']                = $lang->heading;
            $event_langs[$lang->lang]['seo_title']              = $lang->seo_title;
            $event_langs[$lang->lang]['seo_description']        = $lang->seo_description;
            $event_langs[$lang->lang]['seo_text']               = $lang->seo_text;
        }
        $data['event_langs'] = $event_langs;

        return view('admin.events.form', $data);
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
            'uri'                 => [
                'required',
                'regex:/^[a-z_0-9\.-]+$/i',
                Rule::unique('events')->ignore($id),
            ],
            'langs.*.name'      => 'required|string',
            'langs.*.heading'   => 'required|string',
            'langs.*.seo_title' => 'required|string',
            'price'             => 'required|integer',
            'image'             => 'nullable|image|dimensions:max_width=2400,max_height=1350',
            'type'              => 'required|integer|exists:events_types,id',
            'restaurant'        => 'required|integer|exists:restaurants,id',
        ));

        $event = Events::with('langs')->findOrFail($id);

        $event->uri             = $request->uri;
        $event->sorting         = isset($request->sorting) ? $request->sorting : 10;
        $event->active          = $request->is_active == "on";
        $event->price           = $request->price;
        $event->event_type_id   = $request->type;
        $event->restaurant_id   = $request->restaurant;

        $u_image = $request->file('image');
        if(isset($u_image)){
            if(isset($event->image_id)){
                $image = ImageController::imageUpload($u_image, 'uploads/events_thumbs/'.$event->id.'/', true, $event->image_id);
            }else{
                $image = ImageController::imageUpload($u_image, 'uploads/events_thumbs/'.$event->id.'/');
            }
            ImageController::imageResize($image, config('image.sizes.card'));
            $event->image_id = $image->id;
        }

        $event->save();

        foreach($request->lang as $key => $lang) {
            foreach($event->langs as $save_lang){
                if($save_lang->lang == $key){

                    $save_lang->lang            = $key;
                    $save_lang->name            = $lang['name'];
                    $save_lang->heading         = $lang['heading'];
                    $save_lang->seo_title       = $lang['seo_title'];
                    $save_lang->seo_description = $lang['seo_description'];
                    $save_lang->seo_text        = $lang['seo_text'];

                    $save_lang->save();
                }
            }
        }

        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Events::with(['galleries','langs','image'])->findOrFail($id);

        if($event->galleries->count() > 0){
            foreach($event->gelleries as $gallery){
                foreach($gallery->items() as $item){
                    $item->langs()->delete();
                    $item->image()->delete();
                    $item->delete();
                }
                $gallery->langs()->delete();
            }
            $event->galleries()->detach();
        }

        $event->langs()->delete();
        $event->image()->delete();

        $image_folder = 'uploads/events_thumbs/'.$event->id;

        if(file_exists(public_path($image_folder))){
            File::deleteDirectory(public_path($image_folder));
        }

        $event->delete();

        return redirect()->back();
    }
}
