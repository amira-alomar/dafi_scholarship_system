<?php

namespace App\Http\Controllers;

use App\Models\AllUser;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    //register
    public function register(Request $request)
    {
        $request->validate([
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email:dns|max:255|unique:all_users',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string|max:255',
        ]);


        $user = AllUser::create([
            'lname' => $request->lname,
            'fname' => $request->fname,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => '2',
        ]);

        Auth::login($user);
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');;
    }
    //login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        $admin = Admin::where('email', $credentials['email'])->first();
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('admin')->login($admin);
    
            // Redirect based on admin role
            if ($admin->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($admin->role == 'supervisor') {
                return redirect()->route('supervisor.dashboard');
            }
        }    
        //for user
        $user = AllUser::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route(strtolower($user->role->role_name) . '.dashboard');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }
    //logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
