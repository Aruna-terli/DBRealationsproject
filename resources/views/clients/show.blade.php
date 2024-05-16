@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
@section('content')
<a style="font-size:25px;float:left;margin-left:2%" href="{{route('clientdashboard')}}">back</a>

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
                    {{$project->project_name}}
                   
                    <br> 
                @endforeach
            @else
                No projects
            @endif
        </td>
               <td><a href="{{route('clients.edit',$client['id'])}}" style="float:left;width:50%" >update</a>
                                
              </tr>
            @endforeach

        </table>
        
    </div>      
@endsection