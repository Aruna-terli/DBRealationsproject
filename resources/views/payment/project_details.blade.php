@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
@section('content')
<a style="font-size:25px" href="{{route('clientdashboard')}}">back</a>

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
                <th>Amount</th>
              
                <th>Actions</th>
            </tr>
            @foreach($projects as $project)
             
               <tr>
               <td>{{$project['project_name']}}</td>
               <td>{{$project['project_type']}}</td>
               
               <td>{{$project['Amount']}}</td>
               
               <td><a href="{{ route('project_link',['id' => $project['id'],'user_id'=> $user_id])}}">buy now</a>
                                
              </tr>
            @endforeach
            @foreach($paid_projects as $project)
             
             <tr>
             <td>{{$project['project_name']}}</td>
             <td>{{$project['project_type']}}</td>
             <td>{{$project['amount']}}</td>
             
             <td><a href="{{ route('project_link',['id' => $project['id'],'user_id'=> $user_id])}}">buy now</a>
                              
            </tr>
          @endforeach


        </table>
        
    </div>      
@endsection