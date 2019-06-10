<?php

namespace Tests\Feature;

use App\Recipe;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Faker\Factory;

class RecipeTest extends TestCase
{
    // use RefreshDatabase;
    protected $user;
    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * Create user and get token
     * @return string
     */
    // protected function authenticate()
    // {
    //     $user = User::create([
    //         'name' => 'test',
    //         'email' => 'test@gmail.com',
    //         'password' => Hash::make('secret1234'),
    //     ]);
    //     $this->user = $user;
    //     $token = JWTAuth::fromUser($user);
    //     return $token;
    // }

    public function testAll()
    {
        //Authenticate and attach recipe to user
        // $token = $this->authenticate();
        $recipes = factory(Recipe::class, 20)->create()->map(function ($recipe) {
            return $recipe->only(['id', 'title', 'content', 'user_id']);
        });
        $this->user->recipes()->save($recipes);

        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET', route('recipe.all'));
        $response->assertStatus(200)
        // ->assertJsonFragment($recipes->toArray())
        ->assertJsonStructure([
            '*' => [ 'id', 'title', 'procedure' ],
        ]);
    }

    // public function testShow()
    // {
    //     $token = $this->authenticate();
    //     $recipe = factory(Recipe::class)->create();
    //     $this->user->recipes()->save($recipe);
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer '. $token,
    //     ])->json('GET', route('recipe.show', ['recipe' => $recipe->id]));
    //     $response->assertStatus(200);

    //     //Assert title is correct
    //     $this->assertEquals($recipe->title, $response->json()['title']);
    // }
    
    // public function testCreate()
    // {
    //     //Get token
    //     $token = $this->authenticate();
    //     $data = [
    //         'title' => $this->faker->sentence,
    //         'procedure' => $this->faker->paragraph,
    //     ];
    //     $response = $this->withHeaders(['Authorization' => 'Bearer '. $token,])
    //                 ->json('POST', route('recipe.create'), $data);
    //     $response->assertStatus(200);
    //     //Get count and assert
    //     $count = $this->user->recipes()->count();
    //     $this->assertEquals(1, $count);
    // }

    // public function testUpdate()
    // {
    //     $token = $this->authenticate();
    //     $recipe = factory(Recipe::class)->create();
    //     $this->user->recipes()->save($recipe);
    //     $data = [
    //         'title' => $this->faker->sentence,
    //         'procedure' => $this->faker->paragraph
    //     ];
    //     //call route and assert response
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer '. $token,
    //     ])->json('POST', route('recipe.update', ['recipe' => $recipe->id]), [
    //         'title' => $data['title'],
    //     ]);
    //     $response->assertStatus(200);

    //     //Assert title is the new title
    //     $this->assertEquals($data['title'], $this->user->recipes()->first()->title);
    // }

    // public function testDelete()
    // {
    //     $token = $this->authenticate();
    //     $recipe = factory(Recipe::class)->create();
    //     $this->user->recipes()->save($recipe);

    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer '. $token,
    //     ])->json('POST', route('recipe.delete', ['recipe' => $recipe->id]));
    //     $response->assertStatus(200);

    //     //Assert there are no recipes
    //     $this->assertEquals(0, $this->user->recipes()->count());
    // }
}
