<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRoleEnum;

class LoginController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
    
        return view('login');
    }
  
    public function save(RegisterRequest $request)
    {
        
        
        $user = new User;
       
        $user->name = $request['full_name'];
        $user->email = $request['email'];
        $user->phone_no = $request['phone_no'];
        $user->password = Hash::make($request['password']);
        $user->gender = $request['gender'];
        $user->role = $request['role']; 
      
        $user->save();
        
        if ($user) {
           
            return redirect()->route('login')->with('success', "Welcome! You have successfully registered with us.");
        } else {
            return redirect()->back()->with('fail', 'Sorry, your registration was not completed. Please try again.');
        }
        
    }
    public function register()
    {
        return view('registration');
    }
    public function authenticate(Request $request)
    {  
      
        // $a= \Auth::user()->email;
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
        
            if(\Auth::user()->role->value === UserRoleEnum::Admin)
            {
             return redirect()->route('home')->with('success','your login in succesfully! welcome');
            }
            if(\Auth::user()->role->value == UserRoleEnum::Employee)
            {
                return redirect()->route('employedashboard')->with('success','your login in succesfully! welcome');
            }
            if(\Auth::user()->role->value == UserRoleEnum::Client)
            {
               
             return redirect()->route('clientdashboard')->with('success','your login in succesfully! welcome');
            }
             
        }
        else{
            return redirect()->route('login')->with('fail', "Invalid credentials! please enter vaild email ID or password. ");
        }
            
    
      
    }
    public function admindashboard()
    {
        return view('home');
    }
    public function clientdashboard()
    {
        session::put('client_id' ,\Auth::user()->id);
        return view('clientdashboard')->with('id',\Auth::user()->id);
    }
    public function employedashboard()
    {
        session::put('employe_id' ,\Auth::user()->id);
        return view('employedashboard')->with('id',\Auth::user()->id);
    }
    public function logout(Request $request)
{
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
    
 
    return redirect('/');
    }
}
