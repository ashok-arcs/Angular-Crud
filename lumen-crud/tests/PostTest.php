<?php
namespace Tests;

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Post;
use Firebase\JWT\JWT;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    protected function generateJwtToken() {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => 9, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    /**
     * Test adding a post without token.
     *
     * @return void
     */
    public function testAddPostWithoutToken()
    {
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
        ];

        $response = $this->post('/addpost', $postData);

        $response->seeJsonEquals([
            'error' => 'Token not provided.',
        ]);
    }

    /**
     * Test adding a post with an invalid token.
     *
     * @return void
     */
    public function testAddPostWithInvalidToken()
    {
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
        ];

        $response = $this->post('/addpost', $postData, [
            'token' => 'Bearer InvalidToken',
        ]);

        $response->seeJsonEquals([
            'error' => 'An error while decoding token.',
        ]);
    }

    /**
     * Test adding a post with a valid token.
     *
     * @return void
     */
    public function testAddPostWithValidToken()
    {
        $token = $this->generateJwtToken();
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
        ];
        $response = $this->post('/addpost', $postData, [
            'token' => $token
        ])
        ->seeJson([
            'response' => [
                'created' => true
            ]
         ]);
    }

    /**
     * Test fetching posts with a valid token.
     *
     * @return void
     */
    public function testFetchPostWithValidToken()
    {
        $token = $this->generateJwtToken();
        $response = $this->get('/userpost', [
            'token' => $token,
        ])
        ->seeJson(
            [
                'title' => 'first post',
                'content' => 'this post is for testing',
            ]
         );
    }
}
