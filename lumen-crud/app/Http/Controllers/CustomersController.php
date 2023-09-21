<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class CustomersController extends BaseController 
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

     public function addCustomer(Request $request)
    {
        $request["user_id"] = $request->auth->id;
        $response = $this->validate(
            $request, [
                'name' => 'required',
                'email' => 'required|email|unique:customers',
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
    
        if (!empty($_FILES)) 
        { 
            $image = $request->file('file');
            $imageName = $image->getClientOriginalName();

            if(!empty($imageName))
            {
                $customer->profile_image = $imageName;
                $customer->path = 'images/';
                $image->move($this->getPublicImagePath(), $imageName);
            }
        }
       $res = $customer->save();
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


    public function  customersList(Request $request)
    {
        $response = "User id not exist";
        $user_id = $request->auth->id;
        if($user_id > 0)
        {
            $response = Customers::where('status', 1)->select('id','name','email','phone', 'address', 'profile_image', 'path')->orderBy('id', 'desc')->get();
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

        $delete_post = DB::table('customers')
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
                'name' => 'required',
                'email' => 'required|email|unique:customers,email,' . $id,
                'phone' => 'required',
                'address' => 'required',
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
            $image = $request->file('profile_image');
            $imageName = $image->getClientOriginalName();
            if(!empty($imageName))
            {
                $requestData['profile_image'] = $imageName;
                $requestData['path'] = 'images/';
                $image->move($this->getPublicImagePath(), $imageName);
            }
        }

        $result = DB::table('customers')
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