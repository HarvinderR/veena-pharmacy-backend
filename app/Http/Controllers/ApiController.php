<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ApiController extends Controller
{
    //

    function fetchItems(Request $request){
        $limit = $request->limit;
        if($limit != null){

        }
        $product = Product::offset(0)->limit(10)->get();
        return array("data"=>$product->toArray());
    }

}
