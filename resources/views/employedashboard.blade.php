@extends('layouts.app')
 <link rel="stylesheet" type="text/css" href="{{URL::to('css/style.css')}}">
@section('content')

    <div class="row justify-content-center" style="padding:0% 10%" >
        <div class="col-md-12">
            
            <div class="card" >
                <div class="card-header " style="color:white;background-color: #3e3a3a;">Employee Dasboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
              @endif   
              @if(Session::has('fail'))
             <div class="alert alert-danger">{{Session::get('fail')}}</div>
              @endif
                  
                  
                   <div style="float:left;width:50%">
                       <div class="project-box">
                        
                       <h2>Projects</h2>
                       <a style="color:white"href="{{route('employeprojects',['id' => $id])}}">Your projects and Team</a>
                       
                       </div> 
                   </div>
                </div>
            </div>
        </div>
    </div>

@endsection