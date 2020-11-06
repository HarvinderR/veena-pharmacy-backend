<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class LoginController extends Controller
{
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


        return $request;
    }
}
