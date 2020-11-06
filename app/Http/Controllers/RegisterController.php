<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    function register(){
        return view('RegisterScreen');
    }

    function registerUser(Request $request){


        /*$validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);*/

        /*$validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);*/

        //return $validator->errors();
        $hashedpassword = bcrypt($request->password);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = null;
        try{
            $user = User::create(request(['name', 'email', 'password']));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(["Failed to create user"]);
        }
        //console.log("Message here");
        if($user != null && $user->name == $request->name ){
            return redirect('/');
        }else{
            return redirect()->back()->withErrors(["Server error"]);
        }
    }
}
