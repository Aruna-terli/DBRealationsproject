@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="d-flex justify-content-between mb-3">
                <a style="font-size:20px" href="{{ route('chat') }}">
                <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                <a class="btn btn-dark"  style="margin-right:10px"href="{{ route('users_in_group', ['id' => $group[0]->id]) }}">users in group</a> 
                   <a class="btn btn-dark"  style="margin-right:10px"href="{{ route('group.edit', ['id' => $group[0]->id]) }}">Update Group</a>
                   <a class="btn btn-dark" href="{{ route('group.delete', ['id' => $group[0]->id]) }}">Delete Group</a>
                </div>
                
            </div>
            <div class="card">
                <div class="card-header">{{ __('Add User to Group') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-5">
              @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
              @endif   
              @if(Session::has('error'))
             <div class="alert alert-danger">{{Session::get('error')}}</div>
          @endif  
         </div>
        
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" id="userSearch" class="form-control mb-3" placeholder="Search users...">
                            <div class="list-group" id="userList" style="max-height: 400px; overflow-y: auto;">
                                @foreach($users as $user)
                                    <a href="#" class="list-group-item list-group-item-action" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                        {{ $user->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-9">
                            <form method="POST" action="/group/join" id="joinGroupForm">
                                @csrf
                                <div class="container py-5">
                                    <div class="form-group row">
                                        <p>please click on username to add user into group</p>
                                        <label id="userNameLabel" for="code" class="col-md-4 col-form-label text-md-right"></label>
                                        <div class="col-md-6">
                                            <input id="code" type="hidden" class="form-control @error('code') is-invalid @enderror" value="{{$group[0]->code}}"name="code" value="" required autocomplete="name" autofocus>
                                            <input id="userId" type="hidden" name="user_id" value="">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row mb-2">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary" id="joinButton" style="display: none;">
                                                Join
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('userSearch').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const users = document.querySelectorAll('#userList .list-group-item');
    users.forEach(function(user) {
        const userName = user.textContent.toLowerCase();
        if (userName.includes(query)) {
            user.style.display = 'block';
        } else {
            user.style.display = 'none';
        }
    });
});
    document.addEventListener('DOMContentLoaded', function () {
        const userList = document.getElementById('userList');
        const userNameLabel = document.getElementById('userNameLabel');
        const codeInput = document.getElementById('code');
        const userIdInput = document.getElementById('userId');
        const joinButton = document.getElementById('joinButton');

        userList.addEventListener('click', function (event) {
            if (event.target && event.target.matches('a.list-group-item')) {
                const userId = event.target.getAttribute('data-user-id');
                const userName = event.target.getAttribute('data-user-name');

                userNameLabel.textContent = userName;
                userIdInput.value = userId;

                joinButton.style.display = 'inline-block';
            }
        });
    });
</script>
@endsection
