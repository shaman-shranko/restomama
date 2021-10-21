<?php

namespace App\Http\Controllers\Admin;

use App\City as CitiesModel;
use App\Http\Controllers\Controller;
use App\Language;use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Cities extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-cities');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [];
        $data['cities'] = CitiesModel::with('languages')->get();
        return view('admin.cities.index', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.cities.form');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $city = CitiesModel::with('languages')->findOrFail($id);
        $data['city'] = $city;
        $data['city_lang'] = [];
        foreach ($city->languages as $lang) {
            $data['city_lang'][$lang->language]['name'] = $lang->name;
            $data['city_lang'][$lang->language]['seo_title'] = $lang->seo_title;
            $data['city_lang'][$lang->language]['seo_description'] = $lang->seo_description;
            $data['city_lang'][$lang->language]['seo_text'] = $lang->seo_text;
        }
        return view('admin.cities.form', $data);
    }

    /**
     * Store city`s data
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'uri' => 'required|unique:cities|regex:/^[a-z_0-9\.-]+$/i',
            'langs.*.name' => 'required',
            'langs.*.seo_title' => 'required',
        ]);
        $type = new CitiesModel();
        $type_values = array(
            'uri' => $request->uri,
            'sorting' => $request->sorting ?: 0,
            'active' => $request->is_active == "on",
        );
        $type->fill($type_values);
        $type->save();

        $langs = [];
        foreach ($request->langs as $key => $lang) {
            $langs[$key] = new Language();
            $langs[$key]->fill(array(
                'language' => $key,
                'name' => $lang['name'],
                'seo_title' => $lang['seo_title'],
                'seo_description' => $lang['seo_description'],
                'seo_text' => $lang['seo_text'],
            ));
            $type->languages()->save($langs[$key]);
        }
        return redirect()->route('cities.index');
    }

    /**
     * Update city`s data
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'uri' => [
                'required',
                'regex:/^[a-z_0-9\.-]+$/i',
                Rule::unique('cities')->ignore($id),
            ],
            'langs.*.name' => 'required',
            'langs.*.seo_title' => 'required',
        ]);

        $type = CitiesModel::findOrFail($id);

        $type->uri = $request->uri;
        $type->sorting = $request->sorting ?: 0;
        $type->active = $request->is_active == "on";

        $type->save();
        // Save langs for saving type
        foreach ($request->langs as $key => $lang) {
            foreach ($type->languages as $type_lang) {
                if ($type_lang->language == $key) {
                    $type_lang->name = $lang['name'];
                    $type_lang->seo_title = $lang['seo_title'];
                    $type_lang->seo_description = $lang['seo_description'];
                    $type_lang->seo_text = $lang['seo_text'];
                }
                $type_lang->save();
            }
        }
        return redirect()->route('cities.index');
    }

    /**
     * Delete city
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $type = CitiesModel::findOrFail($id);
        $type->languages()->delete();
        $type->delete();
        return redirect()->route('cities.index');
    }
}
