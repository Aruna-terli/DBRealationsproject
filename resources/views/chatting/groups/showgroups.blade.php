@extends('layouts.app')

@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{ URL::to('css/chat.css') }}"> -->

    <a style="font-size:20px" href="{{ route('chat') }}" title="Back">
    <i class="fas fa-arrow-left"></i>
    </a>

<div class="col-md-5">
  @if(Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
  @endif   
  @if(Session::has('fail'))
    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
  @endif  
</div>
<div class="container py-5">
  <div class="row">
    <div class="col-md-3">
      <input type="text" id="groupSearch" class="form-control mb-3" placeholder="Search groups...">
      <div class="list-group" id="groupList" style="max-height: 400px; overflow-y: auto;">
        @foreach($groups as $group)
          <a href="{{ route('group.show', ['group_id' => $group->id,'group_name'=>$group->name]) }}" class="list-group-item list-group-item-action" data-group-id="{{ $group->id }}" data-group-name="{{$group->name}}">
            @if(@$group->count != 0)
            {{ $group->name }} <b style="background-color:red">{{$group->count}}</b>
            @else 
            {{ $group->name }}
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
             
              <div class="card" id="chat1" style="border-radius: 15px; margin-top: 20px;">
                <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                  style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                  @if($group_name)
                  <p class="mb-0 fw-bold">{{$group_name}}</p>
                @endif
                </div>
                <div class="card-body" style="height: 400px; overflow-y: scroll;">
                  <div id="messages">
                    <!-- Messages will be loaded here -->
                    @foreach($messages as $message)
                      <div class="d-flex {{ $message->user_id == auth()->id() ? 'flex-row-reverse' : 'flex-row' }} mb-4">
                        <div class="p-3 {{ $message->user_id == auth()->id() ? 'me-3' : 'ms-3' }} border rounded" style="background-color: {{ $message->user_id == auth()->id() ? '#fbfbfb' : 'rgba(57, 192, 237, .2)' }};">
                        <p ><b>{{$message->from}}</b></p>
                          <p class="small mb-0">{{ $message->message }}</p>
                          
                          <p class="small text-muted">{{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</p>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div data-mdb-input-init class="form-outline">
                    <textarea class="form-control" id="textAreaExample" placeholder="Type your message" rows="4"></textarea>
                    <input id="group_id" type="hidden" class="form-control @error('code') is-invalid @enderror" value="{{@$group_id}}"name="group_id" value="" required autocomplete="name" autofocus>
                    <input id="group_name" type="hidden" class="form-control @error('code') is-invalid @enderror" value="{{@$group_name}}"name="group_name" value="" required autocomplete="name" autofocus>
                    <button id="sendMessage" class="btn btn-primary mt-2" >Send</button>
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


document.getElementById('groupList').addEventListener('click', function (event) {
    if (event.target && event.target.matches('a.list-group-item')) {
        const groupId = event.target.getAttribute('data-group-id');
      //   const GroupName = event.target.getAttribute('data-group-name');
      //  console.log(GroupName);
      //  chat1.innerHTML=`<p ><b>${GroupName}</b></p>`;
        
        // fetchMessages(groupId);
       
    }
});


document.getElementById('sendMessage').addEventListener('click', function () {
    const message = document.getElementById('textAreaExample').value;
    const group_id = document.getElementById('group_id').value;
    const group_name = document.getElementById('group_name').value
    

   
    

    fetch('{{ route('sendGroupMessage') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
            message: message, 
            group_id: group_id,
            group_name :group_name,
            name: '{{ auth()->user()->name }}' 
        })
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
            <p ><b>${data.message.name}</b></p>
                <p class="small mb-0">${data.message.message}</p>
                <p class="small text-muted">${formattedReceivedTime }</p>
            </div>
        `;
        messagesDiv.appendChild(messageElement);
    }).catch(error => {
        console.error('Error:', error);
    });
});

function fetchMessages(groupId) {
    fetch(`/messages/${groupId}`)
        .then(response => response.json())
        .then(data => {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.innerHTML = '';
            data.messages.forEach(message => {
                appendMessage(message, message.sender_id == {{ auth()->id() }});
            });
        });
}

function appendMessage(message, isSender) {
    const messagesDiv = document.getElementById('messages');
    const messageElement = document.createElement('div');
    messageElement.classList.add('d-flex', isSender ? 'flex-row-reverse' : 'flex-row', 'mb-4');
    messageElement.innerHTML = `
        <div class="p-3 ${isSender ? 'me-3' : 'ms-3'} border rounded" style="background-color: ${isSender ? '#fbfbfb' : 'rgba(57, 192, 237, .2)'};">
            <p class="small mb-0">${message.message}</p>
           
        </div>
    `;
    messagesDiv.appendChild(messageElement);
}

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
                <p ><b>${e.name}</b></p>
                    <p class="small mb-0">${e.message}</p>
                    <p class="small text-muted">${formattedReceivedTime }</p>
                  
                </div>
            `;
            messagesDiv.appendChild(messageElement);
  }
});

// Echo.channel('public')
//     .listen('MessageSent', (e) => {
//         const groupId = document.getElementById('sendMessage').getAttribute('data-group-id');
      
//         if (e.message.group_id == groupId) {
//             const messagesDiv = document.getElementById('messages');
//             const messageElement = document.createElement('div');
//             messageElement.classList.add('d-flex', 'flex-row', 'mb-4');
//             messageElement.innerHTML = `
//                 <div class="p-3 ms-3 border rounded" style="background-color: rgba(57, 192, 237, .2);">
//                     <p class="small mb-0">${e.message.message}</p>
                    
//                 </div>
//             `;
//             messagesDiv.appendChild(messageElement);
//         }
//     });
</script>
@endsection
