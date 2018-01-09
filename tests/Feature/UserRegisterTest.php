<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegisterTest extends TestCase
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

    public function testsRegistersSuccessfully()
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
            'password_confirmation' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'returnType',
                'message'
            ]);
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->json('post', '/api/register')
            ->assertStatus(200)
            ->assertJson([
                'returnType' => 'error',
            	'message' =>array(
            		'name' => [
				            "The name field is required."
			        ],
            		'email' => [
				            "The email field is required."
			        ],
			        "password" => [
			            "The password field is required."
			        ],
			        "password_confirmation" => [
			        	"The password confirmation field is required."
			        ])
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'John Will',
            'email' => 'johnwill@toptal.com',
            'password' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(200)
            ->assertJson([
               'returnType' => 'error',
            	'message' =>array(
			        "password" => [
			            "The password confirmation does not match."
			        ],
			        "password_confirmation" => [
			        	"The password confirmation field is required."
			        ])
            ]);
    }
}
