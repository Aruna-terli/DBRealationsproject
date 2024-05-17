<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
           
            return redirect()->to('login')->with('success', "Welcome! You have successfully registered with us.");
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
        
            if(\Auth::user()->role == 3)
            {
             return redirect()->route('home');
            }
            if(\Auth::user()->role == 2)
            {
                return redirect()->route('employedashboard');
            }
            if(\Auth::user()->role == 1)
            {
               
             return redirect()->route('clientdashboard');
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
        return view('clientdashboard')->with('id',\Auth::user()->id);
    }
    public function employedashboard()
    {
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
