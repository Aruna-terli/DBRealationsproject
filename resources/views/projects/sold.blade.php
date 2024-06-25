@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
@section('content')
<a style="font-size:20px" href="{{route('projects.index')}}" title="Back">
<i class="fas fa-arrow-left"></i>
</a>

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
              
                <th>client name</th>
                <th>Employe Name</th>
                
            </tr>
           
             
              
             
               
                @foreach($users as $user)
                @foreach($user->client_employees as $client)
               
                 @if($client->pivot->project_id == $project[0]['id'])
                <tr>
                <td>{{$project[0]['name']}}</td>
                <td>
                {{$client->name}}<br>
                
                 </td>
                 <td>
                   
               @if($user->role->value == "2" && $client->role == "1" )
                {{$user->name}}<br>
                @endif
           
                </td>
                </tr>
                @endif
             @endforeach
             @endforeach
                                
            
         

        </table>
        
    </div>      
@endsection