<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class LoginController extends Controller
{
    function show(){
        if(auth()->user()!=null){
//            Artisan::call('route:clear');
            return redirect('home');
        }else{
            return \response()->view('LoginScreen')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }

    //
    function login(Request $request){
        $input = $request->all();

        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        if(auth()->attempt(array($fieldType => $input['name'], 'password' => $input['password'])))
        {
            Artisan::call('route:clear');
            return redirect('home');
        }else{
            return redirect()->back()->withErrors(['Invalid username or password']);
        }
    }

    function logout(){
        auth()->logout();
        Artisan::call('route:clear');
        return redirect('login');
    }
}
