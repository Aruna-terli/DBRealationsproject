<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Projects;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class clientcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = User::select("*")

       ->where("role", "=", 1)
        ->with('clientProjects')->get();
          return view('clients.index')->with('clients',$clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('clients/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = $request->validate([
            
            'full_name'=>'required',
            'email_id'=>'required|email|unique:user',
            'phone_no'=>'required|digits:10',
            'password'=>'required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/|required_with:re_password|same:re_password',
            're_password'=>'min:6|required',
            'gender'=>'required',
           
        ]);
    
       
       
       
       $user = new User;
      
        $user->name = $request['full_name'];
        $user->email =$request['email_id'];
        $user->phone_no= $request['phone_no'];
        $user->password = Hash::make($request['password']);
       
        $user->gender = $request['gender'];
        $user->role = "1";
        $user->save();
        if($user)
        {
            return redirect()->To('clients')->with('success',"welcome! ,successfully registered with us");
        }
        else 
        {
            return redirect()->back()->with('fail','sorry!, your registertion was not compelted please try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::where("role", "=", 1 )->where( "id" ,"=",$id)->with('clientProjects')->get();
     
       
        return view('clients/show')->with('clients',$client);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $client = User::select("*")->where("role", "=", 1 )->where( "id" ,"=",$id)->get();
      
        
        return view('clients/update')->with('client',$client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $validation = $request->validate([
            
            'full_name'=>'required',
            'email_id'=>'required|email|unique:user',
            'phone_no'=>'required|digits:10',
            'gender'=>'required',
         ]);
     
       $user =  User::find($id);
       
        $user->name = $request['full_name'];
        $user->email =$request['email_id'];
        $user->phone_no= $request['phone_no'];
        $user->gender = $request['gender'];
       
        $user->update();
        if($user)
        {
            if($user->role == '1')
            {
                return redirect()->route('clients.show', ['client' => $id])->with('success', 'Welcome! Successfully updated.');

            }
            else{
                return redirect()->To('clients')->with('success',"welcome! ,successfully updated ");
            }
            
        }
        else 
        {
            return redirect()->back()->with('fail','sorry!, your updation  was not compelted please try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $client = User::find($id);
        $client->destroy($id);
        if($client)
        {
            return redirect()->To('clients')->with('success','successfully! deleted  Your project');
        }
        else{
            return redirect()->back()->with('fail','sorry! your project   was not deleted please try again ');
        }
    }
    public function assignEmployeview()

    {
      
        $employes = User::where('role','=',2)->get();
        $client_id = Session::get('client_id');
    
        $client = User::with('clientProjects')->where('id',$client_id)->get();

        $project = $client[0]->clientProjects;
        
      
        return view('clients.hire')->with(['employes' => $employes, 'projects' => $project]);

    }
    public function assignEmploye(Request $request)
    {
        $validation = $request->validate([
            'project_id' =>'required',
            'employe_id'=>'required',
           
         ]);
  
         $projects = Projects::where('id',$request['project_id'])->update(['user_id'=>$request['employe_id']]);
         $user = User::where('id', $request['employe_id'])->first();
       
        if ($user) {
            $user->clientProjects()->attach($request['project_id'], ['role_id' => 2]);
         }
          

         if($projects && $user){
            return redirect()->To('employes')->with('success','successfully! hired this employe to  Your project');
         }
         else{
            return redirect()->back()->with('fail','sorry! your project   was not assigned to that empolye please try again ');
         }

    }
}
