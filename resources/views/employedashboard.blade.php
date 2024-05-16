@extends('layouts.app')
 <link rel="stylesheet" type="text/css" href="{{URL::to('css/style.css')}}">
@section('content')
<div class="container"  >
    <div class="row justify-content-center" >
        <div class="col-md-12">
            
            <div class="card" >
                <div class="card-header " style="color:white">Employe Dasboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>your login in succesfully! welcome<h4> 
                    <div style="float:left;width:50%">
                       <div class="project-box">
                        
                       <h2>projects</h2>
                       <a style="color:white"href="{{route('employes.show',['employe' => $id])}}">view and edit your profile</a>
                       
                       </div> 
                   </div>
                   <div style="float:right;width:50%">
                       <div class="project-box">
                        
                       <h2>projects</h2>
                       <a style="color:white"href="{{route('employeprojects',['id' => $id])}}">Your projects and Team</a>
                       
                       </div> 
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection