@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/style.css') }}">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="color:white;background-color: #3e3a3a;">Admin Dasboard</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="col-md-5 mt-5">
              @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
              @endif   
              @if(Session::has('fail'))
             <div class="alert alert-danger"  style="margin-left:30px">{{Session::get('fail')}}</div>
              @endif  
         </div>
                  
                    <div class="content-container">
                        <div class="project-box">
                        <h2>projects </h2>
                       <a style="color:white"href="{{route('projects.index')}}">project operations</a>
                        </div>
                        <div class="project-box">
                        <h2>Clients</h2>
                       <a style="color:white"href="{{route('clients.index')}}">Clients operations</a>
                        </div>
                        <div class="project-box">
                        <h2> projects</h2>
                       <a style="color:white"href="{{route('projects_sold')}}">sold projects details</a>
                       
                        </div>
                        <div class="project-box">
                        <h2> Employee</h2>
                       <a style="color:white"href="{{route('employes.index')}}">Employee details</a>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

