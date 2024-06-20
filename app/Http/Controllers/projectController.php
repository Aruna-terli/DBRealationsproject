<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\projects;


class projectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $projects =  Projects::with('clients')->get();

        
       return  view('projects/index')->with(['projects'=>$projects]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('projects/create');

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
        $validation =$request->validate([

            'project_name' =>'required',
            'price'        =>'required|numeric|gt:0',
            'project_type' =>'required',
            'description'  =>'required|max:2000',
        ]);
        $project =new projects;
       
        $project['name'] = $request['project_name'];
        $project['amount'] = $request['price'];
        $project['type'] = $request['project_type'];
        $project['description'] = $request['description'];
        $project['status'] = '1';
        
      
        $project->save();
        $request->session()->flash('success', 'Successfully registered your project');
        if($project)
        {
            return redirect()->To('projects')->with('success','successfully! registered Your project');
        }
        else{
            return redirect()->back()->with('fail','sorry! your registertion was not compelted please try again ');
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
        //

       
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
       $project = projects::find($id);
    
       return  view('projects/update')->with('project',$project);
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
        
        
        $validation =$request->validate([

            'project_name' =>'required',
            'price'        =>'required|numeric|gt:0',
            'project_type' =>'required',
            'description'  =>'required|max:2000',
        ]);
        $project = projects::find($id);
        $project['name'] = $request['project_name'];
        $project['amount'] = $request['price'];
        $project['type'] = $request['project_type'];
        $project['description'] = $request['description'];
       
        $project->update();
        $request->session()->flash('success', 'Successfully updated your project');
        if($project)
        {
            return redirect()->To('projects')->with('success','successfully! updated  Your project');
        }
        else{
            return redirect()->back()->with('fail','sorry! your updation  was not compelted please try again ');
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
        
        $project = projects::find($id);
        $project->delete($id);
        if($project)
        {
            return redirect()->To('projects')->with('success','successfully! deleted  Your project');
        }
        else{
            return redirect()->back()->with('fail','sorry! your project   was not deleted please try again ');
        }
        
          
      
    }
}
