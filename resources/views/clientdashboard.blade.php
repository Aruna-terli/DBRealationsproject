@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/style.css') }}">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="color:white;background-color: #3e3a3a;">client Dashboard</div>
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
                  
                    <div class="content-container">
                        <div class="project-box">
                            <h3>Projects</h3>
                            <a style="color:white" href="{{ route('project_buy', ['id' => $id]) }}">Buy Projects</a>
                        </div>
                        <div class="project-box">
                            <h3>Clients</h3>
                            <a style="color:white" href="{{ route('clients.show', ['client' => $id]) }}">Clients crud operations</a>
                        </div>
                        <div class="project-box">
                            <h3>Employees</h3>
                            <a style="color:white" href="{{ route('employes.index') }}">Hire employees!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
