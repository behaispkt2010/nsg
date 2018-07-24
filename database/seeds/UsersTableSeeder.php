<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $admin = new \App\User();
        $admin->name = "admin";
        $admin->email = "admin@gmail.com";
        $admin->password = "admin";
        $admin->image = '/images/user_default.png';
        $admin->save();

        $editor = new \App\User();
        $editor->name = "editor";
        $editor->email = "editor@gmail.com";
        $editor->password = "editor";
        $editor->image = '/images/user_default.png';
        $editor->save();

        $user = new \App\User();
        $user->name = "user";
        $user->email = "user@gmail.com";
        $user->password = "user";
        $user->image = '/images/user_default.png';
        $user->save();

        $user = new \App\User();
        $user->name = "kho";
        $user->email = "kho@gmail.com";
        $user->password = "kho";
        $user->image = '/images/user_default.png';
        $user->save();
    }
}
