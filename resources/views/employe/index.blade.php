@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">


@section('content')

@if (auth()->user()->role->value == 2)
<a style="font-size:20px;margin-left:35px;" href="{{ route('employedashboard') }}">
        <i class="fas fa-arrow-left"></i> 
    </a>
@elseif (auth()->user()->role->value == 1)
    <a style="font-size:20px;margin-left:35px;" href="{{ route('clientdashboard') }}">
        <i class="fas fa-arrow-left"></i> 
    </a>
    <a style="font-size:20px;float:right;margin-right:4%"href="{{route('employes.create')}}">Register new Employee</a>
@else
    <a style="font-size:20px;margin-left: 35px;" href="{{ route('home') }}" title="Back">
    <i class="fas fa-arrow-left"></i>
    </a>
    <a style="font-size:20px;float:right;margin-right:4%"href="{{route('employes.create')}}">Register new Employee</a>
@endif

<!-- <a style="font-size:20px;float:right;margin-right:4%"href="{{route('clients.create')}}">Register new client</a> -->
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
            <th>Contact NO</th>
            <th>Gender</th>
            <th>Projects</th>
            <th>Actions</th>
        </tr>
        @foreach($employes as $employe)
            <tr>
                <td>{{ $employe['name'] }}</td>
                <td>{{ $employe['email'] }}</td>
                <td>{{ $employe['phone_no'] }}</td>
                <td>{{ $employe['gender'] }}</td>
                <td>
                    @if(!empty($employe['client_employees'])) 
                        @foreach($employe['client_employees'] as $empl)
                            @if(!empty($empl->clientProjects))
                                @foreach($empl->clientProjects as $project)
                                  @if($empl->pivot->project_id == $project->id)
                                    {{ $project->name }}<br>
                                    @endif
                                @endforeach
                            @else
                                No projects 
                            @endif
                        @endforeach
                    @endif
                </td>
                <td>
                @if(auth()->user()->role->value == 1)
                        <a href="{{ route('assignEmployeview', $employe['id']) }}" style="float:left;width:50%" title="Assign Project">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="{{ route('unassignEmployeview', $employe['id']) }}" style="float:left;width:50%" title="Unassign Project">
                            <i class="fas fa-minus"></i>
                        </a>
                    @elseif (auth()->user()->role->value == 3)
                        <a href="{{ route('employes.edit', $employe['id']) }}" style="float:left;width:50%" title="Update">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($employe->clientProjects->isEmpty())
                            <form action="{{ route('employes.destroy', $employe['id']) }}" method="post" style="float:right;width:50%">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none;border:none;color:red;cursor:pointer;" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>  
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>
        
    </div>      
@endsection