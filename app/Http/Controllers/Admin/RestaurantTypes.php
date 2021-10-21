<?php

namespace App\Http\Controllers\Admin;

use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RestaurantType as Types;
use Illuminate\Validation\Rule;

class RestaurantTypes extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-restaurant-categories');
    }

    /**
     * Show list of restaurant types
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = [];
        $data['types'] = Types::with('languages')->get();
        return view('admin.restaurant_types.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return view('admin.restaurant_types.form');
    }

    /**
     * Store the new resource
     */
    public function store(Request $request){
        $validatedData = $request->validate([
            'uri'                 => 'required|unique:restaurant_types|regex:/^[a-z_0-9\.-]+$/i',
            'langs.*.name'        => 'required',
            'langs.*.seo_title'   => 'required',
        ]);
        // Save settings of type
        $type = new Types();
        $type_values = array(
            'uri'     => $request->uri,
            'sorting' => $request->sorting ?: 0,
            'active'  => $request->is_active == "on",
        );
        $type->fill($type_values);
        $type->save();
        // Save langs for saving type
        $langs = [];
        foreach($request->langs as $key => $lang) {
            $langs[$key] = new Language();
            $langs[$key]->fill(array(
                'language'              => $key,
                'name'           => $lang['name'],
                'seo_title'         => $lang['seo_title'],
                'seo_description'   => $lang['seo_description'],
                'seo_text'          => $lang['seo_text'],
            ));
            $type->languages()->save($langs[$key]);
        }
        return redirect()->route('restaurant-types.index');
    }

    /**
     * Display a resource
     */
    public function show($id){

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = Types::with('languages')->findOrFail($id);
        $data['type'] = $type;
        $data['type_lang'] = [];
        foreach($type->languages as $lang){
            $data['type_lang'][$lang->language]['name'] = $lang->name;
            $data['type_lang'][$lang->language]['seo_title'] = $lang->seo_title;
            $data['type_lang'][$lang->language]['seo_description'] = $lang->seo_description;
            $data['type_lang'][$lang->language]['seo_text'] = $lang->seo_text;
        }
        return view('admin.restaurant_types.form', $data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id = null, Request $request){
        $validatedData = $request->validate([
            'uri'                 => [
                'required',
                'regex:/^[a-z_0-9\.-]+$/i',
                Rule::unique('restaurant_types')->ignore($id),
            ],
            'langs.*.name'        => 'required',
            'langs.*.seo_title'   => 'required',
        ]);

        $type = Types::findOrFail($id);

        $type->uri = $request->uri;
        $type->sorting = $request->sorting ?: 0;
        $type->active = $request->is_active == "on";

        $type->save();
        // Save langs for saving type
        foreach($request->langs as $key => $lang) {
            foreach($type->languages as $type_lang){
                if($type_lang->language == $key){
                    $type_lang->name = $lang['name'];
                    $type_lang->seo_title = $lang['seo_title'];
                    $type_lang->seo_description = $lang['seo_description'];
                    $type_lang->seo_text = $lang['seo_text'];
                }
                $type_lang->save();
            }
        }
        return redirect()->route('restaurant-types.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $type = Types::findOrFail($id);
        $type->languages()->delete();
        $type->delete();
        return redirect()->route('restaurant-types.index');
    }
}
