@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
@section('content')
@if (auth()->user()->role == 2)
    <a style="font-size:25px" href="{{ route('employedashboard') }}">back</a>
@elseif (auth()->user()->role == 1)
    <a style="font-size:25px" href="{{ route('clientdashboard') }}">back</a>
@else
    <a style="font-size:25px" href="{{ route('home') }}">back</a>
@endif
<a style="font-size:20px;float:right;margin-right:4%"href="{{route('clients.create')}}">Register new client</a>
               @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif   
                @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
               @endif         
    <div id="clients">
        <table>
            <tr>
                <th>Client Name</th>
                <th>Email Id</th>
                <th>Contant NO</th>
                <th>Gender</th>
                <th>projects</th>
                <th>Actions</th>
            </tr>
            @foreach($clients as $client)
               <tr>
               <td>{{$client['name']}}</td>
               <td>{{$client['email']}}</td>
               <td>{{$client['phone_no']}}</td>
               <td>{{$client['gender']}}</td>
              
               <td>
            @if(!empty($client->clientProjects))
                @foreach($client->clientProjects as $project)
                    {{$project->name}}
                    <br> <!-- Add a line break for each project -->
                @endforeach
            @else
                No projects <!-- Display a message if no projects are found -->
            @endif
        </td>
               <td><a href="{{route('clients.edit',$client['id'])}}" style="float:left;width:50%" >update</a>
               <form action="{{route('clients.destroy',$client['id'])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="float:right;width:50%" value=delete>delete</button>
               </form>                    
              </tr>
            @endforeach

        </table>
        
    </div>      
@endsection