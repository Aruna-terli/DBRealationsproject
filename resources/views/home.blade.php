@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/style.css') }}">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="color:white">Admin Dasboard</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h4>your login in successfully! welcome<h4>
                    <div class="content-container">
                        <div class="project-box">
                        <h2>projects </h2>
                       <a style="color:white"href="{{route('projects.index')}}">project crud operations</a>
                        </div>
                        <div class="project-box">
                        <h2>Clients</h2>
                       <a style="color:white"href="{{route('clients.index')}}">Clients crud operations</a>
                        </div>
                        <div class="project-box">
                        <h2> projects</h2>
                       <a style="color:white"href="{{route('projects_sold')}}">sold projects details</a>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

