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
               <tr>
               <td>{{$project['name']}}</td>
               <td>{{$project['type']}}</td>
               <td>{{$project['description']}}</td>
               
               <td>
            @if(!empty($project->clients))
                @foreach($project->clients as $user)
                @if($user->role == '1')
                    {{$user->name}} <br>
                 @endif   
                    
                @endforeach
            @else
                
            @endif
        </td>
        <td>
            @if(!empty($project->clients))
                @foreach($project->clients as $user)
                @if($user->role == '2')
                    {{$user->name}} <br>
                    @endif
                    
                    
                @endforeach
            @else
                
            @endif
        </td>
                                
              </tr>
            @endforeach

        </table>
        
    </div>      
@endsection