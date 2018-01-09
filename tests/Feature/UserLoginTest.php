<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
     public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(200)
            ->assertJson([
            	'returnType' => 'error',
            	'message' =>array(
            			'email' => [
				            "The email field is required."
				        ],
				        "password" => [
				            "The password field is required."
				        ])
				    
          ]);
    }


    public function testUserLoginsSuccessfully()
    {
        $user = factory(\App\User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
            	"returnType",
			    "message",
			    "user" => [
			        "id",
			        "name",
			        "email",
			        "created_at",
			        "updated_at"
			    	]
                ]);

    }
}
