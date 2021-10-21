<?php

namespace App\Http\Controllers\Admin;

use App\GalleryItems;
use App\GalleryItemsLangs;
use App\Hall;
use App\Language;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class HallsController extends Controller
{
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
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['restaurant'] = Restaurant::where('id','=',$id)->with('languages')->first();
        return view('admin.halls.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $request->validate([
            'name.*'   => 'required|string',
            'capacity' => 'required|integer',
            'sorting'  => 'required|integer',
            'type'     => 'required'
        ]);
        $restaurant = Restaurant::findOrFail($id);
        $hall = new Hall();
        $hall->capacity = $request->capacity;
        $hall->sorting  = $request->sorting;
        $hall->active   = $request->is_active == 'on';
        $hall->type     = $request->type;
        $restaurant->halls()->save($hall);
        foreach ($request->name as $key => $name){
            $hall_lang              = new Language();
            $hall_lang->language    = $key;
            $hall_lang->name        = $name;
            $hall->languages()->save($hall_lang);
        }
        return redirect()->route('restaurants.show', ['id'=>$id]);
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
        $hall = Hall::with(['languages','gallery'])->findOrFail($id);
        $data['hall'] = $hall;
        return view('admin.halls.form', $data);
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
        $request->validate([
            'items.*.*.title' => 'string|nullable',
            'items.*.*.subtitle' => 'string|nullable',
            'name.*'   => 'required|string',
            'capacity' => 'required|integer',
            'sorting'  => 'required|integer'
        ]);
        $hall = Hall::with(['languages','gallery'])->findOrFail($id);
        $hall->capacity = $request->capacity;
        $hall->sorting = $request->sorting;
        $hall->active = $request->is_active == "on";
        $hall->type = $request->type;
        $hall->save();
        /** @var HallsLangs $lang */
        foreach($hall->languages as $lang){
            $lang->name = $request->name[$lang->language];
            $lang->save();
        }
        if(isset($hall->gallery_id)){
            /** @var GalleryItems $item */
            foreach($hall->gallery->items as $item){
                /** @var GalleryItemsLangs $lang */
                foreach($item->langs as $lang){
                    if(isset($request->items[$item->id][$lang->lang]['title'])){
                        $lang->title = $request->items[$item->id][$lang->lang]['title'];
                        $lang->alt = $request->items[$item->id][$lang->lang]['title'];
                    }
                    if(isset($request->items[$item->id][$lang->lang]['subtitle'])){
                        $lang->subtitle = $request->items[$item->id][$lang->lang]['subtitle'];
                    }
                    $lang->save();
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $hall = Hall::with(['langs','gallery','restaurant'])->findOrFail($id);
        $hall->langs()->delete();
        if(isset($hall->gallery)){
            foreach($hall->gallery->items as $item){
                if(file_exists(public_path($item->image->filepath))) {
                    unlink(public_path($item->image->filepath));
                }
                $item->langs()->delete();
                $item->image()->delete();
                $item->delete();
            }
            $hall->gallery()->delete();
        }
        File::deleteDirectory(public_path('uploads/'.$hall->restaurant->id.'/hall/'.$id));
        $hall->delete();

        return redirect()->back();
    }


}
