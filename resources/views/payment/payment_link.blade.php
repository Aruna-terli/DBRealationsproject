<!-- <div class="card card-default">
    <div class="card-header">
      Welcome {{$user["name"]}} buying a new project {{$project['name']}} !
    </div>
    <div class="card-body text-center">
        <form action="{{ route('razorpay_payment') }}" method="POST" >
            @csrf 
            <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{ env('RAZORPAY_KEY') }}"
                    data-amount="{{ $project['amount'] * 100 }}" 
                    data-buttontext="Pay {{ $project['amount'] }} INR"
                    data-description="{{$project['name']}}"
                    data-image="/images/logo-icon.png"
                    data-prefill.name="{{$user['name']}}"
                    data-notes.product_name="{{$project['name']}}"
                    data-notes.product_id="{{$project['id']}}"
                    data-notes.user_id="{{$user['id']}}"
                    data-notes.email = "{{$user['email']}}"                    
                    data-prefill.email="{{$user['email']}}"
                    data-theme.color="#ff7529">
            </script>
        </form>
    </div>
</div> -->
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
    }

    .card-header {
      background-color: #ff7529;
      color: white;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      text-align: center;
      font-size: 20px;
      padding: 20px;
    }

    .card-body {
      padding: 30px;
    }

    .text-center {
      text-align: center;
    }

    .razorpay-payment-button {
      background-color: #ff7529;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .razorpay-payment-button:hover {
      background-color: #e6601c;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card card-default">
      <div class="card-header">
        Welcome {{$user["name"]}}! You're buying a new project: {{$project['name']}}
      </div>
      <div class="card-body text-center">
        <form action="{{ route('razorpay_payment') }}" method="POST">
          @csrf
          <script src="https://checkout.razorpay.com/v1/checkout.js"
                  data-key="{{ env('RAZORPAY_KEY') }}"
                  data-amount="{{ $project['amount'] * 100 }}"
                  data-buttontext="Pay {{ $project['amount'] }} INR"
                  data-description="{{ $project['name'] }}"
                  data-image="/images/logo-icon.png"
                  data-prefill.name="{{ $user['name'] }}"
                  data-prefill.email="{{ $user['email'] }}"
                  data-notes.product_name="{{ $project['name'] }}"
                  data-notes.product_id="{{ $project['id'] }}"
                  data-notes.user_id="{{ $user['id'] }}"
                  data-notes.email="{{ $user['email'] }}"
                  data-theme.color="#ff7529">
          </script>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
