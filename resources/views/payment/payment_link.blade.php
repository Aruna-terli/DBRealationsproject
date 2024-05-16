<div class="card card-default">
    <div class="card-header">
      Welcome {{$user["name"]}} buying a new project {{$project['project_name']}} !
    </div>
    <div class="card-body text-center">
        <form action="{{ route('razorpay_payment') }}" method="POST" >
            @csrf 
            <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{ env('RAZORPAY_KEY') }}"
                    data-amount="{{ $project['Amount'] * 100 }}" 
                    data-buttontext="Pay {{ $project['Amount'] }} INR"
                    data-description="{{$project['project_name']}}"
                    data-image="/images/logo-icon.png"
                    data-prefill.name="{{$user['name']}}"
                    data-notes.product_name="{{$project['project_name']}}"
                    data-notes.product_id="{{$project['id']}}"
                    data-notes.user_id="{{$user['id']}}"
                    data-notes.email = "{{$user['email']}}"                    
                    data-prefill.email="{{$user['email']}}"
                    data-theme.color="#ff7529">
            </script>
        </form>
    </div>
</div>
