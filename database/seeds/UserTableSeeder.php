<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_superuser     = Role::where('alias', 'superuser')->first();

        $super = new User();
        $super->name = 'Viktor';
        $super->surname = 'Skydanchuck';
        $super->email = 'rikardo.verdo@gmail.com';
        $super->phone = '+380662029016';
        $super->password = bcrypt('secret');
        $super->save();
        $super->roles()->save($role_superuser);
    }
}
