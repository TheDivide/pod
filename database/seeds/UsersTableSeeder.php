<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

use App\Role;
use App\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();

        $users = array(

            ['fname' => 'Master','lname' => 'Yoda', 'phone' => '+254720123123','email' => 'yoda@mail.com','username' => 'yoda@mail.com','password' => bcrypt('secretitis')]

        );

        foreach ($users as $user)
        {
            User::create($user);

        }

        $role = Role::where('name', '=', 'admin')->firstOrFail();


        $roleuser = User::where('email', '=', 'yoda@mail.com')->firstOrFail();

// role attach alias
        $roleuser->attachRole($role);

    }
}
