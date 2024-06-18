@extends('layouts.app')

@section('content')

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@if (auth()->user()->role == 2)
    <a style="font-size:25px" href="{{ route('employedashboard') }}">back</a>
@elseif (auth()->user()->role == 1)
    <a style="font-size:25px" href="{{ route('clientdashboard') }}">back</a>
@else
    <a style="font-size:25px" href="{{ route('home') }}">back</a>
@endif
<div class="col-md-5">
              @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
              @endif   
              @if(Session::has('fail'))
             <div class="alert alert-danger">{{Session::get('fail')}}</div>
          @endif  
         </div>
<div class="container py-5">
  <div class="row">
  <div class="col-md-3">
      <input type="text" id="userSearch" class="form-control mb-3" placeholder="Search users...">
      <div class="list-group" id="userList" style="max-height: 400px; overflow-y: auto;">
     
        @foreach($users as $user)
       

          <a href="{{ route('chat', ['user_id' => $user->id,'user_name'=>$user->name]) }}" class="list-group-item list-group-item-action">
            
          @if(@$user->count != 0)
          {{ $user->name }} <b style="background-color:red">{{$user->count}}</b>
          @else 
          {{ $user->name }}
          @endif
         
          </a>
         
        @endforeach
      </div>
    </div>
    <div class="col-md-9">
      <section style="background-color: #eee;">
        <div class="container py-5">
          <div class="row d-flex justify-content-center">
            <div class="col-md-12">
            <a class="btn btn-dark" href="{{ route('group.create') }}">Make group</a>
            <a class="btn btn-dark" href="{{ route('group.show') }}">group chat</a>
           
              <button class="btn btn-dark" id="makeGroupBtn" >Join group</button>
             
              <div id="userDropdown" class="dropdown-content" style="display: none; margin-top: 10px;">
              @foreach($groups as $user)
                <li >
                  <a  href="{{ route('group.join', ['id' => $user->id]) }}" data-user-id="{{ $user->id }}">{{ $user->name }}</a>
                </li>
                @endforeach
              </div>

              <div class="card" id="chat1" style="border-radius: 15px; margin-top: 20px;">
                <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                  style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                
                  @if($user_name)
                  <b>{{$user_name}}</b>
                  @else
                  <p class="mb-0 fw-bold">Live chat</p>
                  @endif
                </div>
                <div class="card-body" style="height: 400px; overflow-y: scroll;">
                  <div id="messages">
                    @foreach($messages as $message)
                      <div class="d-flex {{ $message->sender_id == auth()->id() ? 'flex-row-reverse' : 'flex-row' }} mb-4">
                        <div class="p-3 {{ $message->sender_id == auth()->id() ? 'me-3' : 'ms-3' }} border rounded" style="background-color: {{ $message->sender_id == auth()->id() ? '#fbfbfb' : 'rgba(57, 192, 237, .2)' }};">
                          <p class="small mb-0">{{ $message->message }}</p>
                          <p class="small text-muted">{{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</p>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div data-mdb-input-init class="form-outline">
                    <textarea class="form-control" id="textAreaExample" placeholder="Type your message" rows="4"></textarea>
                    <button id="sendMessage" class="btn btn-primary mt-2">Send</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="module">
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
document.getElementById('makeGroupBtn').addEventListener('click', function () {
    const dropdown = document.getElementById('userDropdown');
    dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
});

document.getElementById('sendMessage').addEventListener('click', function () {
    const message = document.getElementById('textAreaExample').value;
    const receiverId = {{ $receiver->id ?? 'null' }};

    fetch('{{ route('sendmessage') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: message, receiver_id: receiverId })
    }).then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
        return response.json();
    }).then(data => {
        document.getElementById('textAreaExample').value = '';

        const messagesDiv = document.getElementById('messages');
        const messageElement = document.createElement('div');
        const receivedTime = new Date();
        const formattedReceivedTime = receivedTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        messageElement.classList.add('d-flex', 'flex-row-reverse', 'mb-4');
        messageElement.innerHTML = `
            <div class="p-3 me-3 border rounded" style="background-color: #fbfbfb;">
                <p class="small mb-0">${data.message.message}</p>
                <p class="small text-muted">${formattedReceivedTime }</p>
           
            </div>
        `;
        messagesDiv.appendChild(messageElement);
    }).catch(error => {
        console.error('Error:', error);
    });
});
 // Enable pusher logging - don't include this in production
 Pusher.logToConsole = true;

 var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
  cluster: '{{ env('MIX_PUSHER_APP_CLUSTER') }}'
});

var channel = pusher.subscribe('public');
channel.bind('MessageSent', function(e) {


  if (e.sender_id !== {{ auth()->id() }} ) {
            const messagesDiv = document.getElementById('messages');
            const messageElement = document.createElement('div');
            const receivedTime = new Date();
        const formattedReceivedTime = receivedTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            messageElement.classList.add('d-flex', 'flex-row', 'mb-4');
            messageElement.innerHTML = `
                <div class="p-3 ms-3 border rounded" style="background-color: rgba(57, 192, 237, .2);">
                    <p class="small mb-0">${e.message}</p>
                    <p class="small text-muted">${formattedReceivedTime }</p>
                  
                </div>
            `;
            messagesDiv.appendChild(messageElement);
        }
});
// Echo.channel('public')
//     .listen('MessageSent', (data) => {
   
//      console.log(data)
        // if (e.message.sender_id !== {{ auth()->id() }} && e.message.receiver_id === {{ $receiver->id ?? 'null' }}) {
            // const messagesDiv = document.getElementById('messages');
            // const messageElement = document.createElement('div');
            // messageElement.classList.add('d-flex', 'flex-row', 'mb-4');
            // messageElement.innerHTML = `
            //     <div class="p-3 ms-3 border rounded" style="background-color: rgba(57, 192, 237, .2);">
            //         <p class="small mb-0">${e.message.message}</p>
                  
            //     </div>
            // `;
            // messagesDiv.appendChild(messageElement);
        // }
    // });
</script>
@endsection
