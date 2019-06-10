<?php

use Illuminate\Database\Seeder;
use App\Recipe;
use App\User;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Recipe::truncate();

        $faker = \Faker\Factory::create();
        
        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 10; $i++) {
            $user_ids = User::all()->pluck('id')->random(1);
        
            Recipe::create([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
                'user_id' => $user_ids[0]
            ]);
        }
    }
}
