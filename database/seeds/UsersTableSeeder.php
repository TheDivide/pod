<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            DB::table('users')->insert([
                'fname' => $faker->name,
                'lname' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'username' => $faker->unique()->safeEmail,
                'password' => bcrypt('secret'),
            ]);
        }
    }
}
