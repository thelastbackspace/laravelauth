<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Prepare the login data
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
       
        $request = Request::create('/api/login', 'POST', $data);

        $response = Route::dispatch($request);
        // $response = (array) $response;
        $response = json_decode(json_encode($response), true);
    
        // Check if the login was successful
        if ($response["original"]["status"] === 'success') {
            // Login was successful
            // Store the user data and the token in the session
            session(['user' => $response["original"]['user'], 'token' => $response["original"]['authorisation']['token']]);
            // Redirect the user to the dashboard
            return redirect()->route('shubh');
        } else {
            // Login was unsuccessful
            // Redirect the user back to the login page with an error message
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }
}
