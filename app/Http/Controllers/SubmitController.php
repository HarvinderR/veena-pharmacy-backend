<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmitController extends Controller
{
    //
    function getData(Request $request){
        return $request->input();
    }
}
