<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/newuser', 'UserController@createNewUser');
$router->post('/login', 'UserController@loginUser');
$router->post('/forgot-password', 'UserController@forgotPassword');
$router->post('/reset-password', 'UserController@resetPassword');

$router->get('/isValidToken', 'UserController@isValidToken');

/* Get all users using token */
$router->get('users', ['middleware' => 'jwt.token','uses' => 'UserController@showList']);

$router->post('addpost', ['middleware' => 'jwt.token','uses' => 'PostController@createNewPost']);
$router->get('userpost', ['middleware' => 'jwt.token','uses' => 'PostController@showAllPosts']);
$router->delete('deletepost/{id}', ['middleware' => 'jwt.token','uses' => 'PostController@deletePost']);

$router->put('updatepost/{id}', ['middleware' => 'jwt.token','uses' => 'PostController@updatePost']);

$router->get('customers', ['middleware' => 'jwt.token','uses' => 'CustomersController@customersList']);
$router->post('addcustomer', ['middleware' => 'jwt.token','uses' => 'CustomersController@addCustomer']);
$router->delete('deletecustomer/{id}', ['middleware' => 'jwt.token','uses' => 'CustomersController@deleteCustomer']);
$router->post('updatecustomer/{id}', ['middleware' => 'jwt.token','uses' => 'CustomersController@updateCustomer']);


$router->get('products', ['middleware' => 'jwt.token','uses' => 'ProductsController@productsList']);
$router->post('addproduct', ['middleware' => 'jwt.token','uses' => 'ProductsController@addProduct']);
$router->delete('deleteproduct/{id}', ['middleware' => 'jwt.token','uses' => 'ProductsController@deleteCustomer']);
$router->post('updateproduct/{id}', ['middleware' => 'jwt.token','uses' => 'ProductsController@updateCustomer']);

$router->post('addorder', ['middleware' => 'jwt.token','uses' => 'OrdersController@addOrder']);
$router->get('orderlist', ['middleware' => 'jwt.token','uses' => 'OrdersController@getOrdersWithCustomerAndProduct']);
$router->delete('deleteorder/{id}', ['middleware' => 'jwt.token','uses' => 'OrdersController@deleteOrder']);



