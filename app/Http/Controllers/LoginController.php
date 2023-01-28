<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class LoginController extends Controller
{
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function login(Request $request)
    {
        // return $request;
        // Prepare the login data
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
     
        $response = $this->router->dispatch(Request::create('/api/login', 'POST', $data));
        
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
