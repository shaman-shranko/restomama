<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Admin\ImageController as ImageController;

class UserController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data['user'] = User::with(['avatar','roles'])->findOrFail($id);
        return view('account.user.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            // 'role_id' => 'required',
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users')->ignore($id),
            ],
            'phone' => 'required',
        ]);
        $edit_user = User::findOrFail($id);
        $edit_user->name = $request->name;
        $edit_user->surname = $request->surname;
        $edit_user->email = $request->email;
        $edit_user->phone = $request->phone;

        if (isset($request->second_phone)) {
            $edit_user->second_phone = $request->second_phone;
        }

        $u_image = $request->file('image');
        if (isset($u_image)) {
            if (isset($edit_user->image_id)) {
                $image = ImageController::imageUpload($u_image, 'uploads/users/' . $edit_user->id . '/thumb/', true, $edit_user->image_id);
            } else {
                $image = ImageController::imageUpload($u_image, 'uploads/users/' . $edit_user->id . '/thumb/');
            }
            ImageController::imageResize($image, config('image.sizes.card'));
            $edit_user->image_id = $image->id;
        }

        $edit_user->save();

        // $edit_user->roles()->detach();
        // $edit_user->roles()->attach($request->role_id);

        return redirect()->route('account-settings.edit', ['id' => $id]);
    }
}
