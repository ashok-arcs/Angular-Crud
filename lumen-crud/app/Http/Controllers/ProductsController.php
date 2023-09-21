<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProductsController extends BaseController 
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
    
    private function getPublicImagePath()
    {
        // Construct the absolute path to the 'public' directory
        return base_path('public/images');
    }

     public function addProduct(Request $request)
    {
        $request["user_id"] = $request->auth->id;


        $response = $this->validate(
            $request, [
                'name' => 'required|unique:products',
                'price' => 'required',
                'description' => 'required',
                'user_id' => 'required',
            ]
        );

        $product = new Products();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->user_id = $request->user_id;
    
        if (!empty($_FILES)) 
        { 
            $image = $request->file('file');
            $imageName = $image->getClientOriginalName();

            if(!empty($imageName))
            {
                $product->image = $imageName;
                $product->path = 'images/products/';
                $image->move($this->getPublicImagePath().'/products/', $imageName);
            }
        }

       $res = $product->save();
        if($res)
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


    public function  productsList(Request $request)
    {
        $response = "User id not exist";
        $user_id = $request->auth->id;
        if($user_id > 0)
        {
            $response = Products::where('status', 1)->select('id','name','price', 'description', 'image', 'path')->orderBy('id', 'desc')->get();
        }
        return response()->json($response);
    }


     public function deleteCustomer(Request $request, $id)
    {
        $user_id = $request->auth->id;
        if(empty($id))
        {
            return response()->json([
                'error' => 'Something went wrong.'
            ], 400);
        }

        $delete_post = DB::table('products')
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


     public function updateCustomer(Request $request, $id)
    {
        $user_id = $request->auth->id;
        $response = $this->validate(
            $request, [
                'name' => 'required|unique:products,name,' . $id,
                'price' => 'required',
                'description' => 'required',
            ]
        );

        if(empty($id) || empty($user_id))
        {
            return response()->json([
                'error' => 'Something went wrong.'
            ], 400);
        }
        
        $requestData = $request->all();
        $requestData['user_id'] = $user_id;

        if (!empty($_FILES)) 
        {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            if(!empty($imageName))
            {
                $requestData['image'] = $imageName;
                $requestData['path'] = 'images/products/';
                $image->move($this->getPublicImagePath().'/products/'   , $imageName);
            }
        }

        $result = DB::table('products')
        ->where('id', $id)
        ->update($requestData);
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
                    'updated' => 'Customer not found'
                ]
            ];
        }
        return response()->json($response);
    }
}