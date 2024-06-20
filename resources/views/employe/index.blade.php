@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
@section('content')

@if (auth()->user()->role == 2)
    <a style="font-size:25px" href="{{ route('employedashboard') }}">back</a>
@elseif (auth()->user()->role == 1)
    <a style="font-size:25px" href="{{ route('clientdashboard') }}">back</a>
@else
    <a style="font-size:25px" href="{{ route('home') }}">back</a>
    <a style="font-size:20px;float:right;margin-right:4%"href="{{route('employes.create')}}">Register new Employee</a>
@endif

<!-- <a style="font-size:25px;float:right;margin-right:4%"href="{{route('clients.create')}}">Register new client</a> -->
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
            @if(!empty($employe->clientProjects))
                @foreach($employe->clientProjects as $project)
                    {{$project->name}}
                    <br> 
                @endforeach
            @else
                No projects 
            @endif
        </td>
        
               <td>
                @if(auth()->user()->role == 1)
                <a href="{{route('assignEmployeview',$employe['id'])}}" style="float:left;width:50%" >assign project</a>
                @elseif (auth()->user()->role == 3)
                <a href="{{route('employes.edit',$employe['id'])}}" style="float:left;width:50%" >Update </a>
                     @if($employe->clientProjects->isEmpty())
                        <form action="{{route('employes.destroy',$employe['id'])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="float:right;width:50%" value=delete>delete</button>
                        </form>  
                     @endif

                @endif
              </td>
               <!-- <form action="{{route('employes.destroy',$employe['id'])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="float:right;width:50%" value=delete>delete</button>
               </form>                     -->
              </tr>
            @endforeach

        </table>
        
    </div>      
@endsection