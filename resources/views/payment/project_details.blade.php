@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/registration.css') }}">
@section('content')
<a style="font-size:20px" href="{{ route('clientdashboard') }}">
<i class="fas fa-arrow-left"></i>
</a>

@if(Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@endif   
@if(Session::has('fail'))
    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
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
            @php
                $showProject = true;
            @endphp

            @if(count($project->clients) == 0)
                <tr>
                    <td>{{ $project['name'] }}</td>
                    <td>{{ $project['type'] }}</td>
                    <td>{{ $project['amount'] }}</td>
                    <td><a href="{{ route('project_link', ['id' => $project['id'], 'user_id' => $user_id]) }}">buy now</a></td>
                </tr>
            @else
                @foreach($project->clients as $client)
                    @if($client->pivot->user_id == auth()->id())
                        @php
                            $showProject = false;
                        @endphp
                        @break
                    @endif
                @endforeach

                @if($showProject)
                    <tr>
                        <td>{{ $project['name'] }}</td>
                        <td>{{ $project['type'] }}</td>
                        <td>{{ $project['amount'] }}</td>
                        <td><a href="{{ route('project_link', ['id' => $project['id'], 'user_id' => $user_id]) }}">buy now</a></td>
                    </tr>
                @endif
            @endif
        @endforeach
    </table>
</div>
@endsection
