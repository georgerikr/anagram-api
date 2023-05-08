<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{    
    // Function for authentication
    public function login(Request $request)
    {
        // Request input email from react form
        $input_email = $request->input('data.email');
        // Request input password from react form
        $input_password = $request->input('data.password');
        // Select users from database where users table email matches input email
        $user = DB::table('users')->where('email', $input_email)->first();
        // Check if the user exists and the password matches the hashed password stored in the database
        if ($user && Hash::check($input_password, $user->password)) {
            // Create a cookie named "approved_user" that we can use for authentication
            $cookie = cookie('approved_user', 'value', 30);
            // Return a "success" key set to true and set the "approved_user" cookie
            return response()->json([
                "success" => true
            ])->cookie($cookie);         
        } else {
            // Return a "success" key set to false and a corresponding message
            return response()->json([
                "success" => false,
                __("Wrong credentials, try again!")
            ]);
        }
    }
    // Function for redirecting user, if set cookie is set or not
    public function cookie() 
    {
        // Check if 'approved_user' cookie exsists, if yes, return index blade, if no, return login blade
        if (Cookie::has('approved_user') == true) {
            return view('index');
        } else {
            return view('login');
        }
    }
}