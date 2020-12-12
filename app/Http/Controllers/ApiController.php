<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    //
    function deleteCartItem(Request $request){
        $request->validate([
            'cart_item_id' => 'required'
        ]);
        $cartItem = CartItem::find($request->cart_item_id);
        $cart_id = $cartItem->cart_id;
        $cartItem->delete();
        $cart = CartItem::where('cart_id',$cart_id)->first();
        //if($cart == null){
            $cc = Cart::find($cart_id);
            $cc->active = -1;
            $cc->save();
        //}
        return "{'response':'success'}";
    }

    function createCartItem(Request $request){
        $request->validate([
            'prod_id' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'cart_id' => 'required'
        ]);
        $cartItem = new CartItem;
        $cartItem->prod_id = $request->prod_id;
        $cartItem->cart_id = $request->cart_id;
        $cartItem->price = $request->price;
        $cartItem->discount = $request->discount;
        $cartItem->quantity = $request->quantity;
        $cartItem->active = 1;
        $cartItem->save();
        return $cartItem;
    }


    function createCart(Request $request){
        $request->validate([
            'first_name' => 'required',
            'user_id' => 'required',
            'mobile' => 'required'
        ]);

        $cart = new Cart;
        $cart->user_id= $request->user_id;
        $cart->status= $request->status;
        $cart->first_name= $request->status;
        $cart->middle_name= $request->middle_name;
        $cart->last_name= $request->last_name;
        $cart->mobile= $request->mobile;
        $cart->email= $request->email;
        $cart->line1= $request->line1;
        $cart->line2= $request->line2;
        $cart->city= $request->city;
        $cart->active= 0;
        $cart->save();

        return $cart;
    }

    function deleteCart(Request $request){
        $request->validate([
            'cart_id' => 'required'
        ]);
        Cart::find($request->cart_id)->delete();
        return "{'response':'success'}";
    }

    function show_user(Request $request){
        return $request->user();
    }

    function login(Request $request){
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);
        $customer = Customer::where('name',$request->name)->first();
        $resp = [];
        if(Hash::check($request->password,$customer->password)){
            if($customer->getRememberToken()){

            }else{
                $customer->setRememberToken(bcrypt(Str::random(30)));
                $customer->save();
            }
            $resp= array( 'id'=>$customer->id,'name'=>$customer->name,'email'=>$customer->email,'token'=>$customer->getRememberToken());
            //return $resp;
        }

        return $resp;
    }

    function fetch_category(){
        $category = DB::select("select * from categories where active = 1");
        $length = count($category);
        for ($i =0; $i < $length; $i++ ){
            $cat_id = $category[$i]->id;
            $res = DB::select('select products.id,products.name,products.salt,products.manufacture,products.price,products.img from r_cat_prod right JOIN products on r_cat_prod.prod_id = products.id WHERE r_cat_prod.cat_id=? ',[$cat_id]);
            $category[$i]->products = $res;
        }
        return array('categories'=>$category);
    }

    function createUser(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $customer = Customer::create(request(['name', 'email', 'password']));
        //$customer->setRememberToken(bcrypt(Str::random(30)));
        //$customer->save();
        return $customer;
    }

    function fetchItems(Request $request){
        $limit = $request->limit;
        if($limit != null){

        }
        $product = Product::offset(0)->limit(10)->get();
        return array("data"=>$product->toArray());
    }

}
