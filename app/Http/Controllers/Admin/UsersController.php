<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:create-users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::all();
        return view('admin.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['roles'] = Role::where('restaurant_role', '=', false)->get();
        return view('admin.users.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'      => 'required',
            'surname'   => 'required',
            'role_id'   => 'required',
            'email'     => [
                'required',
                'email:rfc,dns',
                'unique:users'
            ],
            'phone'     => 'required|unique:users',
        ]);
        $edit_user = new User();
        $edit_user->name         = $request->name;
        $edit_user->surname      = $request->surname;
        $edit_user->email        = $request->email;
        $edit_user->phone        = $request->phone;
        $edit_user->save();

        $edit_user->roles()->detach();
        $edit_user->roles()->attach($request->role_id);

        return redirect()->route('users.index');
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
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::where('restaurant_role', '=', false)->get();
        return view('admin.users.form', $data);
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
        $validatedData = $request->validate([
            'name'      => 'required',
            'surname'   => 'required',
            'role_id'   => 'required',
            'email'     => [
                'required',
                'email:rfc,dns',
                Rule::unique('users')->ignore($id),
            ],
            'phone'     => 'required',
        ]);
        $edit_user = User::findOrFail($id);
        $edit_user->name         = $request->name;
        $edit_user->surname      = $request->surname;
        $edit_user->email        = $request->email;
        $edit_user->phone        = $request->phone;
        $edit_user->save();

        $edit_user->roles()->detach();
        $edit_user->roles()->attach($request->role_id);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('users.index');
    }
}
