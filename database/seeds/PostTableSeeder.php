<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostTableSeeder extends Seeder
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
        for ($i=0; $i < 100; $i++) { 
        	DB::table('posts')->insert([
        		'title' => $faker->sentence,
        		'content' => $faker->paragraph,
        		'user_id' => $faker->create(App\User::class)->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	]);
        }
    }
}
