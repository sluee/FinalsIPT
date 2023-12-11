<?php

namespace App\Http\Controllers;

use App\Jobs\CustomerJob;
use App\Jobs\UserJob;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function loginForm()
    {
        // \App\Jobs\CustomerJob::dispatch();
        if(Auth::check()){
            return redirect()->back();
        }else{
            return view('auth.login');
        }
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user =  User::where('email', $request->email)->first();

        if(!$user || $user->email_verified_at == null){
            return redirect('/login')->with('error', 'Your account is not yet verified or account does not exist');
        }

        $login = auth()->attempt([
            'email' =>$request->email,
            'password'  =>$request->password
        ]);

        if(!$login){
            return back()->with('error', 'Invalid Credentials');
        }

        return redirect('/dashboard');
    }

    public function registerForm()
    {

        if(Auth::check()){
            return redirect()->back();
        }
        return view('auth.register');
    }

    public function register(Request $request)
{
    $request->validate([
        'firstName' => 'required|string',
        'lastName' => 'required|string',
        'phone' => 'required|string',
        'address' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|string|min:6',
    ]);

    $token = Str::random(24);

    $user = User::create([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'address' => $request->address,
        'phone' => $request->phone,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'remember_token' => $token,
    ]);

    // Assuming you have a Customer model, you need to create an instance of it
    $customer = new Customer([
        'user_id' => $user->id,
        // Add other fields related to the customer if needed
    ]);

    $user->customer()->save($customer);

    $customerRole = Role::where('name', 'customer')->first();
    $user->assignRole($customerRole);

    UserJob::dispatch($user);

    return redirect('/login')->with('message', 'Your account has been created. Please check your email for the verification link');
}


    public function verification(User $user, $token){

        if($user->remember_token !== $token){
            return redirect('/login')->with('error', 'Invalid Token');
        }

        $user->email_verified_at = now();
        $user->save();

        dispatch(new UserJob($user));
        return redirect('/login')->with('message', 'Your account has been verified');

    }

    public function dashboard(){

        $currentUser = Auth::user(); // Retrieve the currently logged-in user
        $registeredUsers = User::all();


        return view('dashboard', compact('currentUser', 'registeredUsers'));
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','Log out successfully');
    }
}
