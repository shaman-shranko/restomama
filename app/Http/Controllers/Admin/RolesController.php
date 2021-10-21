<?php

namespace App\Http\Controllers\Admin;

use App\RestaurantTypesLangs as TypesLangs;
use App\Role;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::with('languages')->get();
        return view('admin.roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'alias'            => 'string|required|unique:roles',
           'langs.*.name'     => 'string|required',
        ]);

        $role = new Role();

        $role->alias             = $request->alias;
        $role->restaurant_role   = isset($request->restaurant_role) && $request->restaurant_role === "on";
        $role->save();

        $langs = [];
        foreach($request->langs as $key => $lang) {
            $langs[$key] = new Language();
            $langs[$key]->fill(array(
                'language'              => $key,
                'name'              => $lang['name'],
            ));
            $role->languages()->save($langs[$key]);
        }

        return redirect()->route('roles.index');
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
        $data['item'] = Role::with('languages')->findOrFail($id);
        return view('admin.roles.form', $data);
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
            'alias'            => [
                'string',
                'required',
                Rule::unique('roles')->ignore($id),
                ],
            'langs.*.name'     => 'string|required',
        ]);

        $role = Role::with('languages')->findOrFail($id);

        $role->alias = $request->alias;
        $role->restaurant_role   = isset($request->restaurant_role) && $request->restaurant_role === "on";
        $role->save();

        $langs = [];
        foreach ($request->langs as $key => $lang) {
            foreach ($role->languages as $role_lang) {
                if ($role_lang->language == $key) {
                    $role_lang->name = $lang['name'];
              }
                $role_lang->save();
            }
        }

        
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->languages()->delete();
        $role->delete();

        return redirect()->route('roles.index');
    }
}
