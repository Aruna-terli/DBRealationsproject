@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
@section('content')
<a style="font-size:20px" href="{{route('home')}}" title="Back">
<i class="fas fa-arrow-left"></i>
</a>
<a style="font-size:20px;float:right;margin-right:2%"href="{{route('projects.create')}}">Register new project</a>
                 @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif   
                @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
               @endif 
    <div id="clients">
        <table>
            <tr>
                <th>Project Name</th>
                <th>Project Type</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
            @foreach($projects as $key => $project)
               <tr>
               <td><a href="{{route('projects_sold',['id'=>$project->id])}}">{{$project['name']}}</a></td>
               <td>{{$project['type']}}</td>
               <td>{{$project['amount']}}</td>
              
            <td>
                @if($project['status'] == '1')
                 {{ 'Active' }}
                 @else
                 {{ 'InActive' }}
                 @endif
               </td>
               <td><a href="{{route('projects.edit',$project['id'])}}" title="Edit" style="display: inline-block; margin-right: 20px;">
               <i class="fas fa-edit"></i>
               </a>
               <a href="{{route('changestatus',['id'=>$project['id'],'status'=>$project['status']])}}" title="Change Status" style="display: inline-block; margin-right: 20px;">
               <i class="fas fa-exchange-alt"></i>
               </a>
               @if($project['status'] == '1')
                
                 @else
                 <form action="{{ route('projects.destroy', $project['id'] ) }}" method="post" style="display: inline-block; margin-right: 20px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" value=delete title="Delete" style="background:none; border:none; padding:0; cursor:pointer;">
                                    <i class="fas fa-trash"></i>
                                    </button>
               </form>
                 @endif
                                   
              </tr>
            @endforeach

        </table>
        
    </div>      
@endsection