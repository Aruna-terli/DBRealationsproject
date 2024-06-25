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
<form method ="post" action="{{route('clients.store')}}">  
  @csrf <!-- {{ csrf_field() }} -->
    <div class="reg">
       
        <div class="reg_form">
          <h2>Registration of client</h2>
          <div class="col-md-5">
              @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
              @endif   
              @if(Session::has('fail'))
             <div class="alert alert-danger">{{Session::get('fail')}}</div>
          @endif  
         </div>
         <div class="row"> 
               <div class="left">
               <div class="column2">
              <lable style="font-size:20px" >FullName : </lable>
                       <span style="color :red">*</span>
             
                      <input type= "text"  name ="full_name" placeholder="Enter your full name " size = "25"value="{{ old('full_name') }}" required autocomplete="full_name" autofocus><br>
                      @if ($errors->has('full_name'))
                            <span style="color:red">{{ $errors->first('full_name') }}</span>
                            @endif
              </div>
                    <div >
                        <lable  style="font-size:20px"> Email  ID : </lable>
                         <span style="color :red">*</span>
             
                        <input type= "text"  name ="email" placeholder="Enter your email id " size = "25" value="{{ old('email') }}" required autocomplete="email" autofocus><br>
                          @if ($errors->has('email'))
                            <span style="color:red">{{ $errors->first('email') }}</span>
                            @endif
                    </div>
                    <div class="column1">
                         <lable  style="font-size:20px"> Password : </lable>
                          <span style="color :red">*</span>
             
                          <input type= "password"  name ="password" placeholder="Enter password" size = "25" required><br>
                          @if ($errors->has('password'))
                            <span style="color:red">{{ $errors->first('password') }}</span>
                            @endif
                    </div>
                  
                    </div>
                </div>
</div>

<div class="right">
              
              
              <div class="column2">
              <lable style="font-size:20px" >Phone Number : </lable>
                       <span style="color :red">*</span>
             
                      <input type= "text"  name ="phone_no" placeholder="Enter your phone number " size = "25" value="{{ old('phone_no') }}" required autocomplete="phone_no" autofocus><br>
                      @if ($errors->has('phone_no'))
                         <span style="color:red">{{ $errors->first('phone_no') }}</span>
                        @endif
              </div>
              <div class="column2">
                       <lable class="gender">Choose your Gender</lable>
                        <div class="gen_details">
                            <input type="radio" id= "male" name="gender" value="male" checked>
                            <lable for="male" class="male">Male</lable>
                            <input type="radio" id = "female" name="gender" value="female">
                            <lable for="female" class="female">Female</lable>
                            <input type="radio"  id ="others" name="gender" value="others">
                            <lable for="others" class="others">Others</lable><br>
                            

                        </div>
                        
              <div class="column2">
              <lable style="font-size:20px" >Confirm Password: </lable>
                       <span style="color :red">*</span>
             
                      <input type= "password"  name ="re_password" placeholder="confirm your password " size = "25"><br>
                      @if ($errors->has('re_password'))
                            <span style="color:red">{{ $errors->first('re_password') }}</span>
                            @endif
              </div>
              
          </div>
</div>  
   
          <input type="submit" value="Register" class="btn_reg">
        </div>
    </div>
</div>

 </form>
 
</body>   