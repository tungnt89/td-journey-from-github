<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Faker\Factory;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
    /**
     * @test
     * Test registration
     */
    public function testRegister()
    {
        //User's data
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];

        // $token = JWTAuth::fromUser($user);
        //Send post request
        $response = $this->json('POST', route('api.register'), $data);
        //Assert it was successful
        $response->assertStatus(200);
        //Assert we received a token
        $this->assertArrayHasKey('token', $response->json());
    }

    /**
     * @test
     * Test login
     */
    public function testLogin()
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('secret1234'),
        ]);
        
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token,])->json('POST',route('api.login'),[
                'email' => $user->email,
                'password' => 'secret1234',
            ]);;
        
        $response->assertStatus(200);
    }
}
