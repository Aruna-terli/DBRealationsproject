@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/chat.css') }}">

@if (auth()->user()->role == 2)
    <a style="font-size:25px" href="{{ route('employedashboard') }}">back</a>
@elseif (auth()->user()->role == 1)
    <a style="font-size:25px" href="{{ route('clientdashboard') }}">back</a>
@else
    <a style="font-size:25px" href="{{ route('home') }}">back</a>
@endif

<div class="container py-5">
  <div class="row">
    <div class="col-md-3">
      <input type="text" id="userSearch" class="form-control mb-3" placeholder="Search users...">
      <div class="list-group" id="userList" style="max-height: 400px; overflow-y: auto;">
        @foreach($users as $user)
          <a href="{{ route('chat', ['user_id' => $user->id]) }}" class="list-group-item list-group-item-action">
            {{ $user->name }}
          </a>
        @endforeach
      </div>
    </div>
    <div class="col-md-9">
      <section style="background-color: #eee;">
        <div class="container py-5">
          <div class="row d-flex justify-content-center">
            <div class="col-md-12">
              <div class="card" id="chat1" style="border-radius: 15px;">
                <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                  style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                  <p class="mb-0 fw-bold">Live chat</p>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: scroll;">
                  <div id="messages">
                    @foreach($messages as $message)
                      <div class="d-flex {{ $message->sender_id == auth()->id() ? 'flex-row-reverse' : 'flex-row' }} mb-4">
                        <div class="p-3 {{ $message->sender_id == auth()->id() ? 'me-3' : 'ms-3' }} border rounded" style="background-color: {{ $message->sender_id == auth()->id() ? '#fbfbfb' : 'rgba(57, 192, 237, .2)' }};">
                          <p class="small mb-0">{{ $message->message }}</p>
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
        // Clear the text area
        document.getElementById('textAreaExample').value = '';

        // Optionally add the message to the view
        const messagesDiv = document.getElementById('messages');
        const messageElement = document.createElement('div');
        messageElement.classList.add('d-flex', 'flex-row-reverse', 'mb-4');
        messageElement.innerHTML = `
            <div class="p-3 me-3 border rounded" style="background-color: #fbfbfb;">
                <p class="small mb-0">${data.message}</p>
            </div>
        `;
        messagesDiv.appendChild(messageElement);
        messagesDiv.scrollTop = messagesDiv.scrollHeight; // Scroll to bottom
    }).catch(error => {
        console.error('Error:', error);
    });
});

Echo.channel('public')
    .listen('MessageSent', (e) => {
        if (e.message.sender_id !== {{ auth()->id() }} && e.message.receiver_id === {{ $receiver->id ?? 'null' }}) {
            const messagesDiv = document.getElementById('messages');
            const messageElement = document.createElement('div');
            messageElement.classList.add('d-flex', 'flex-row', 'mb-4');
            messageElement.innerHTML = `
                <div class="p-3 ms-3 border rounded" style="background-color: rgba(57, 192, 237, .2);">
                    <p class="small mb-0">${e.message.message}</p>
                </div>
            `;
            messagesDiv.appendChild(messageElement);
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // Scroll to bottom
        }
    });

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
</script>
@endsection
