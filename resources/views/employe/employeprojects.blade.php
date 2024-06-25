@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
@section('content')
<a style="font-size:25px" href="{{route('employedashboard')}}">back</a>

                 @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif   
                @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
               @endif 
    <div id="customers">
        <table>
            <tr>
                <th>Project Name</th>
                <th>Project Type</th>
                <th>Description</th>
                <th>Your Client</th>
                <th>Your Team</th>
                
            </tr>
            @foreach($projects as $project)
            @foreach($project->client_employees as $client)
             @foreach($client->clientProjects as $project)
             @if($client->pivot->project_id == $project->id)
               <tr>
               <td>{{$project['name']}}</td>
               <td>{{$project['type']}}</td>
               <td>{{$project['description']}}</td>
               
               <td>
                 {{$client->name}} <br>
   
                </td>
                <td>
                    @foreach($employees as $employee)
                    @if($employee->project_id == $project->id  && $employee->client_id == $client->id)
                    {{$employee->name}}<br>
                    @endif
                    @endforeach
           
               </td>
                                
              </tr>
              @endif
              @endforeach
            @endforeach
            @endforeach

        </table>
        
    </div>      
@endsection