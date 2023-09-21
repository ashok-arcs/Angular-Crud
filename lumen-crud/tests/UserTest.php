<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;

class UserTest extends TestCase
{

    /**
     * Test a register request with missing required fields.
     *
     * @return void
     */
    public function testRegisterMissingFields()
    {
        $response = $this->post('/newuser', []);
        $response->seeJsonEquals([
            'name' => ['The name field is required.'],
            'email' => ['The email field is required.'],
            'password' => ['The password field is required.'],
        ]);
    }


    /**
     * Test a new user case.
     *
     * @return void
     */
    //  public function testRegisterWithParams()
    // {
    //     $this->json('POST', '/newuser', ['name' => 'uuuuuuuuuuuu', 'email' => '1www11eeedQ@gmail.com', 'password' => 'hello@123'])
    //          ->seeJson([
    //             'response' => [
    //                 'created' => true
    //             ]
    //          ]);
    // }

    /**
     * Test a login request with missing required fields.
     *
     * @return void
     */
    public function testLoginMissingFields()
    {
        $response = $this->post('/login', []);
        $response->seeJsonEquals([
            'email' => ['The email field is required.'],
            'password' => ['The password field is required.'],
        ]);
    }

     /**
     * Test a login request with invalid credentials.
     *
     * @return void
     */
    public function testLoginInvalidCredentials()
    {
        $response = $this->post('/login', [
            'email' => 'qwertyQ@gmail.com',
            'password' => 'invalid_password',
        ]);

        $response->seeJsonEquals([
            'error' => 'Email or password is wrong.',
        ]);
    }

     /**
     * Test a successful login request.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => app('hash')->make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->seeJsonStructure([
            'token',
        ]);
    }
}
