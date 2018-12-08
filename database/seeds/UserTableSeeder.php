<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        for ($i=0; $i < 2; $i++) { 
        	DB::table('users')->insert([
        		'name' => $faker->name,
        		'email' => $faker->email,
        		'password' => bcrypt('secret'),
        		'status' => 'Active',
        		'username' => $faker->userName(4),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	]);
        }
    }
}
