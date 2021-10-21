<?php

namespace App\Http\Controllers\Admin;

use App\Galleries;
use App\GalleryItemsLangs;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-restaurants');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['restaurant'] = Restaurant::where('id','=',$id)->with('menu')->first();
        return view('admin.menus.form', $data);
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
        ]);
        $gallery = Galleries::where('id','=',$id)->with(['items','menu_restaurant'])->first();
        foreach($gallery->items as $item){
            /** @var GalleryItemsLangs $lang */
            foreach($item->langs as $lang){
                $lang->title = $request->items[$item->id][$lang->lang]['title'];
                $lang->subtitle = $request->items[$item->id][$lang->lang]['subtitle'];
                if(isset($request->items[$item->id][$lang->lang]['title'])){
                    foreach($gallery->menu_restaurant->languages as $r_lang){
                        if($lang->lang == $r_lang->language){
                            $lang->alt = $r_lang->title.'. '.$request->items[$item->id][$lang->lang]['title'];
                        }
                    }
                }
                $lang->save();
            }
        }
        return redirect()->back();
    }
}
