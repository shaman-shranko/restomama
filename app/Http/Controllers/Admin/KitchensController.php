<?php

namespace App\Http\Controllers\Admin;

use App\Kitchen;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KitchensController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-restaurants');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data['items'] = Kitchen::with('languages')->get();
        return view('admin.kitchens.index', $data);
    }

    /**
     *
     */
    public function show(){
        //
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('admin.kitchens.form');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data['item'] = Kitchen::with('languages')->findOrFail($id);
        return view('admin.kitchens.form', $data);
    }

    /**
     * Save info
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $request->validate([
            'name.*' => 'required'
        ]);

        $kitchen = new Kitchen();
        $kitchen->save();
        foreach (config('app.locales') as $lang){
            $k_lang = new Language();
            $k_lang->language = $lang;
            $k_lang->name = $request->name[$lang];
            $kitchen->languages()->save($k_lang);
        }

        return redirect()->route('kitchens.index');
    }

    /**
     * Update info
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request){
        $request->validate([
            'name.*' => 'required'
        ]);

        $kitchen = Kitchen::with('languages')->findOrFail($id);

        foreach ($kitchen->languages as $lang){
            $lang->name = $request->name[$lang->language];
            $lang->save();
        }

        return redirect()->route('kitchens.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id){
        $kitchen = Kitchen::findOrFail($id);
        $kitchen->languages()->delete();
        $kitchen->delete();
        return redirect()->route('kitchens.index');
    }
}
