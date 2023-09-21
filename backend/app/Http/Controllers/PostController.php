<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class PostController extends BaseController 
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) 
    {
        $this->request = $request;
    }


    public function createNewPost(Request $request)
    {
        $request["user_id"] = $request->auth->id;
        $response = $this->validate(
            $request, [
                'title' => 'required',
                'content' => 'required',
                'user_id' => 'required'
            ]
        );
        
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        $post->save();
        
        if($post->save())
        {
            $response = response()->json(
                [
                    'response' => [
                        'created' => true
                    ]
                ], 201
            );
        }
        return $response;
    }


    public function showAllPosts(Request $request)
    {
        $response = "User id not exist";
        $user_id = $request->auth->id;
        if($user_id > 0)
        {
            $sort = "id";
            $direction = "desc";
            if(!empty($request->sortBy))
            {
                $sort = $request->sortBy;
            }

            if(!empty($request->sortOrder))
            {
                $direction = $request->sortOrder;
            }
            $response = Post::where('user_id', $user_id)->select('id','user_id','title','content')->orderBy($request->sortBy, $request->sortOrder)->get();
        }
        return response()->json($response);
    }

    public function updatePost(Request $request, $id)
    {
        $user_id = $request->auth->id;

        $response = $this->validate(
            $request, [
                'title' => 'required',
                'content' => 'required'
            ]
        );
        if(empty($id) || empty($user_id))
        {
            return response()->json([
                'error' => 'Something went wrong.'
            ], 400);
        }

        $result = DB::table('posts')
        ->where('id', $id)
        ->where('user_id', $user_id)
        ->update($request->all());
        if($result)
        {
            $response =
            [
                'response' => [
                    'updated' => 'Successfully'
                ]
            ];
        }
        else
        {
            $response =
            [
                'response' => [
                    'updated' => 'Post not found'
                ]
            ];
        }
        return response()->json($response);
    }
    
    public function deletePost(Request $request, $id)
    {
        $user_id = $request->auth->id;
        if(empty($id))
        {
            return response()->json([
                'error' => 'Something went wrong.'
            ], 400);
        }

        $delete_post = DB::table('posts')
                    ->where('id', $id)
                    ->delete();  
        if($delete_post)
        {
            $response = "Success";
        }
        else {
         $response = "Error";   
        }

        return response()->json($response);
    }


     public function addCustomer(Request $request)
    {
        $request["user_id"] = $request->auth->id;
        $response = $this->validate(
            $request, [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'user_id' => 'required'
            ]
        );
        
        $customer = new Customers();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->user_id = $request->user_id;
        $customer->save();
        
        if($customer->save())
        {
            $response = response()->json(
                [
                    'response' => [
                        'created' => true
                    ]
                ], 201
            );
        }
        return $response;
    }
}