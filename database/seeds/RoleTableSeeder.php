<?php


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\Permission;


class RoleTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        DB::table('roles')->delete();

        $roles = array(
            ['name' => 'admin','display_name' => 'User Administrator','description' => 'User is pretty much a Jedi.'],
            ['name' => 'owner','display_name' => 'Project Owner','description' => 'User is the owner of a given project.']

        );

        // Loop through each user above and create the record for them in the database
        foreach ($roles as $role)
        {
            Role::create($role);
        }

        $permission = Permission::where('name', '=', 'create')->firstOrFail();

        $role_permission = Role::where('name', '=', 'admin')->firstOrFail();

        $role_permission->attachPermission($permission);

        Model::reguard();
    }
}
