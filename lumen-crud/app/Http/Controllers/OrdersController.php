<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class OrdersController extends BaseController 
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


     public function addOrder(Request $request)
    {
        $request["user_id"] = $request->auth->id;
        $response = $this->validate(
            $request, [
                'customer_id' => 'required',
                'product_id' => 'required',
                'product_description' => 'required',
                'product_price' => 'required',
                'user_id' => 'required'
            ]
        );

        $customer = new Orders();
        $customer->customer_id = $request->customer_id;
        $customer->product_id = $request->product_id;
        $customer->product_description = $request->product_description;
        $customer->product_price = $request->product_price;
        $customer->user_id = $request->user_id;

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


    public function getOrdersWithCustomerAndProduct(Request $request)
    {
        $orders = Orders::join('customers', 'orders.customer_id', '=', 'customers.id')      
                        ->join('products', 'orders.product_id', '=', 'products.id')
                        ->select('orders.*','customers.name as customer_name', 'products.name as product_name')
                        ->orderBy('orders.id', 'desc')
                        ->get();

        return response()->json($orders);
    }


     public function deleteOrder(Request $request, $id)
    {
        $user_id = $request->auth->id;
        if(empty($id))
        {
            return response()->json([
                'error' => 'Something went wrong.'
            ], 400);
        }

        $delete_post = DB::table('orders')
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
}