<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
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

    public function testsRequiresPasswordOldAndNew()
    {
        $this->json('put', '/api/reset')
            ->assertStatus(200)
            ->assertJson([
                'returnType' => 'error',
            	'message' =>array(
            		'old_password' => [
				            "The old password field is required."
			        ],
			        "password" => [
			            "The password field is required."
			        ],
			        "password_confirmation" => [
			        	"The password confirmation field is required."
			        ])
            ]);
    }
    public function testsRequireResetPasswordConfirmation()
    {
        $payload = [
            'old_password' => 'toptal123',
            'password' => 'toptal12345',
        ];

        $this->json('put', '/api/reset', $payload)
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
    public function testsOldPasswordConfirmation()
    {

        $payload = [
            'old_password' => 'toptal1234',
            'password' => 'toptal12345',
            'password_confirmation' => 'toptal12345',
        ];
         $credential = ['email' => 'john@toptal.com', 'password' => 'toptal123'];

        $this->json('POST', 'api/login', $credential)
            ->assertStatus(200);

        $this->json('put', '/api/reset', $payload)
            ->assertStatus(200)
            ->assertJson([
               'returnType' => 'error',
            	'message' => 'Your old password does not match.'
            ]);
    }
    public function testsResetPasswordSuccessfully()
    {
        $payload = [
        	'old_password' => 'toptal123',
            'password' => 'toptal12345',
            'password_confirmation' => 'toptal12345',
        ];
        $credential = ['email' => 'john@toptal.com', 'password' => 'toptal123'];

        $this->json('POST', 'api/login', $credential)
            ->assertStatus(200);

        $this->json('put', '/api/reset', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'returnType',
                'message'
            ]);
    }

}
