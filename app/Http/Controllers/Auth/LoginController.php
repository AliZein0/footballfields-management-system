<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
   

    use AuthenticatesUsers;

  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    
    /**
     * The user has been authenticated.
     * Override the method from AuthenticatesUsers trait
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Check if user has role_id of 2
        if($user->role_id == 2) {
            // Redirect to the admin dashboard
            return redirect('/players');
                
        
    }else if($user->role_id == 1) {
            // Redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        }else{
            // Redirect to the user dashboard
            return redirect('/home');
        }
    }
}