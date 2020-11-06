<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    function show($id){
        return DB::select("select * from test");
//        return "Hello show $id";
    }
}
