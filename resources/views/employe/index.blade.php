@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
@section('content')
<a style="font-size:25px;float:left;margin-left:2%" href="{{route('clientdashboard')}}">back</a>

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
            @if(!empty($employe->employeeProjects))
                @foreach($employe->employeeProjects as $project)
                    {{$project->project_name}}
                    <br> 
                @endforeach
            @else
                No projects 
            @endif
        </td>
        
               <td>
                <a href="{{route('assignEmployeview')}}" style="float:left;width:50%" >assign project</a>
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