<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('permissions')->delete();

        $permissions = array(
            ['name' => 'create','display_name' => 'Create','description' => 'create new stuff.'],
            ['name' => 'edit','display_name' => 'Edit','description' => 'edit stuff.'],
            ['name' => 'read','display_name' => 'Read','description' => 'read stuff.']

        );

        // Loop through each user above and create the record for them in the database
        foreach ($permissions as $permission)
        {
            Permission::create($permission);
        }

        Model::reguard();
    }
}
