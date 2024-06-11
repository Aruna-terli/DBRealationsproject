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
               @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif   
                @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
               @endif         
    <div id="clients">
        <table>
            <tr>
                <th>Employe Name</th>
                <th>Email Id</th>
                <th>Contant NO</th>
                <th>Gender</th>
                <th>projects</th>
                <th>Actions</th>
            </tr>
            @foreach($employes as $employe)
               <tr>
               <td>{{$employe['name']}}</td>
               <td>{{$employe['email']}}</td>
               <td>{{$employe['phone_no']}}</td>
               <td>{{$employe['gender']}}</td>
              
               <td>
            @if(!empty($employe->employeeProjects))
                @foreach($employe->employeeProjects as $project)
                    {{$project->project_name}}
                   
                    <br> <!-- Add a line break for each project -->
                @endforeach
            @else
                No projects <!-- Display a message if no projects are found -->
            @endif
        </td>
               <td><a href="{{route('employes.edit',$employe['id'])}}" style="float:left;width:50%" >update</a>
                                
              </tr>
            @endforeach

        </table>
        
    </div>      
@endsection