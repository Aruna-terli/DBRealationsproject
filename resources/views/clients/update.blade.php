<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
</head>
<body>
@if (auth()->user()->role->value == 2)
    <a style="font-size:25px" href="{{ route('employedashboard') }}">back</a>
@elseif (auth()->user()->role->value == 1)
    <a style="font-size:25px" href="{{ route('clientdashboard') }}">back</a>
@else
    <a style="font-size:25px" href="{{ route('home') }}">back</a>
@endif
<form method ="post" action="{{route('clients.update',$client[0]->id)}}">  
  @csrf <!-- {{ csrf_field() }} -->
  @method('PUT')

    <div class="reg">
       
        <div class="reg_form">
        <!-- <a href="{{route('clients.index')}}" style="float:right;margin:5% 5%;font-size:22px">back</a> -->
        <div class="row" style="padding-left:35px">    
          <h2>Update client</h2>
            <div class="col-md-5">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif   
                @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif  
            </div>
           
            <!-- <div>
                    
                    <lable  style="font-size:20px"> UserId : </lable>
                    <span style="color :red">*</span>
      
                    <input type= "text"  style="width:70%;margin-left:9%" name ="user_id" placeholder="enter your user id " size = "25" value="{{$client[0]->user_id}}" required autocomplete="user_id" autofocus><br>
              
                     @if ($errors->has('user_id'))
                     <span style="color:red">{{ $errors->first('user_id') }}</span>
                     @endif
             
            </div> -->
            <div class="column2">
              <lable style="font-size:20px" >FullName : </lable>
                       <span style="color :red">*</span>
             
                      <input type= "text" style="width:70%;margin-left:6%" name ="full_name" placeholder="enter your full name " size = "25"value="{{ $client[0]->name }}" required autocomplete="full_name" autofocus><br>
                      @if ($errors->has('full_name'))
                            <span style="color:red">{{ $errors->first('full_name') }}</span>
                            @endif
              </div>
             <div >
                 <lable  style="font-size:20px"> Email  ID : </lable>
                  <span style="color :red">*</span>
      
                 <input type= "text"  style="width:70%;margin-left:7%" name ="email_id" placeholder="enter your email id " size = "25" value="{{$client[0]->email}}"readonly required autocomplete="email_id" autofocus><br>
                   @if ($errors->has('email_id'))
                     <span style="color:red">{{ $errors->first('email_id') }}</span>
                     @endif
             </div>
             <div class="column2">
              <lable style="font-size:20px" >Phone Number : </lable>
                       <span style="color :red">*</span>
             
                      <input type= "text"  style="width:70%" name ="phone_no" placeholder="enter your phone number " size = "25" value="{{$client[0]->phone_no}} " required autocomplete="phone_no" autofocus><br>
                      @if ($errors->has('phone_no'))
                         <span style="color:red">{{ $errors->first('phone_no') }}</span>
                        @endif
              </div>
             <div class="column1">
                       <lable class="gender">Choose your Gender</lable>
                        <div class="gen_details">

                        @if($client[0]->gender == "male")
                            <input type="radio" id= "male" name="gender" value="male" checked>
                         @else
                         <input type="radio" id= "male" name="gender" value="male" >   
                         @endif
                        <lable for="male" class="male">Male</lable>
                            @if($client[0]->gender == "female")
                            <input type="radio" id = "female" name="gender" value="female" checked>
                            @else
                            <input type="radio" id = "female" name="gender" value="female" >
                            @endif
                        <lable for="female" class="female">Female</lable>
                           @if($client[0]->gender == "others")
                            <input type="radio"  id ="others" name="gender" value="others" checked>
                            @else
                            <input type="radio"  id ="others" name="gender" value="others">
                            @endif
                        <lable for="others" class="others">Others</lable><br>
                            

                        </div>
                        
                    </div>
                   
             
            
            
          <input type="submit" value="update" class="btn_reg">
        </div>
    </div>
</div>

 </form>
 
</html>   