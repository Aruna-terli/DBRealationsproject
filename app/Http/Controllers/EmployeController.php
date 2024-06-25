<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employes = User::
    where('role', '=', 2)
    ->with('client_employees.clientProjects')
   
    ->get();

    
          return view('employe.index')->with('employes',$employes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employe.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            
            'full_name'=>'required',
            'email'=>'required|email|unique:users',
            'phone_no'=>'required|digits:10',
            'password'=>'required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/|required_with:re_password|same:re_password',
            're_password'=>'min:6|required',
            'gender'=>'required',
           
        ]);
    
       
       
       
       $user = new User;
     
        $user->name = $request['full_name'];
        $user->email =$request['email'];
        $user->phone_no= $request['phone_no'];
        $user->password = Hash::make($request['password']);
       
        $user->gender = $request['gender'];
        $user->role = "2";
        $user->save();
        if($user)
        {
            return redirect()->route('employes.index')->with('success',"welcome! ,successfully registered with us");
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
        $employe = User::where( "id" ,"=",$id)->with('clientProjects')->get();
     
      
        return view('employe/show')->with('employes',$employe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employe = User::select("*")->where("role", "=", 2 )->where( "id" ,"=",$id)->get();
      
        
        return view('employe/update')->with('employe',$employe);
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
       
        $validation = $request->validate([
          
            'full_name'=>'required',
            // 'email'=>'required|email|unique:users',
            'phone_no'=>'required|digits:10',
            'gender'=>'required',
         ]);
    
       $user =  User::find($id);
       
        $user->name = $request['full_name'];
        // $user->email =$request['email'];
        $user->phone_no= $request['phone_no'];
        $user->gender = $request['gender'];
     
        $user->update();
        if($user)
        {
           
            if(auth()->user()->role->value == '2')
            {
                return redirect()->route('employes.show', ['employe' => $id])->with('success', 'Welcome! Successfully updated.');

            }
            else{
                return redirect()->To('employes')->with('success',"welcome! ,successfully updated ");
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
        $employe = User::find($id);
        $employe->destroy($id);
       
        if($employe)
        {
            if(auth()->user()->role->value==3)
            {
                return redirect()->To('employes')->with('success','successfully! deleted  Your employee');
            }
            else{
                return redirect()->To('clients')->with('success','successfully! deleted  Your employee');
            }
            
        }
        else{
            return redirect()->back()->with('fail','sorry! your employe   was not deleted please try again ');
        }
    
    }
    public function employeprojects($id){
        $projects = User::with('client_employees.clientProjects')->where('id', $id)->get();
        $employee = User::with('client_employees')
        ->leftjoin('clients_employees','clients_employees.employee_id','=','users.id')->get();
       
     
    //     $projectIds = [];
        
    //     foreach ($employee as $employe) {
    //         foreach ($employe->clientProjects as $project) {
    //             $projectIds[] = [$project->id]; // Collect project IDs in the array
    //         }
    //     }
     
    //   $projects = Projects::whereIn('id',$projectIds)->with('clients')->get();
   
    
        return view('employe/employeprojects')->with( ['projects'=>$projects,'employees'=> $employee]);
    }
}
