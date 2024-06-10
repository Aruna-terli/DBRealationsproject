<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
</head>
<body>
<form method ="post" action="{{route('savedata')}}">  
  @csrf <!-- {{ csrf_field() }} -->
    <div class="reg">
       
        <div class="reg_form">
        <a href="{{route('login')}}" style="float:right;margin:5% 5%;font-size:22px">back</a>
          <h2>Registration</h2>
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
                  <!-- <div>
                    
                           <lable  style="font-size:20px"> UserId : </lable>
                           <span style="color :red">*</span>
             
                           <input type= "text"  name ="user_id" placeholder="enter your user id " size = "25" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus><br>
                     
                            @if ($errors->has('user_id'))
                            <span style="color:red">{{ $errors->first('user_id') }}</span>
                            @endif
                    
                   </div> -->
                     <div class="column2">
              <lable style="font-size:20px" >FullName : </lable>
                       <span style="color :red">*</span>
             
                      <input type= "text"  name ="full_name" placeholder="enter your full name " size = "25"value="{{ old('full_name') }}" required autocomplete="full_name" autofocus><br>
                      @if ($errors->has('full_name'))
                            <span style="color:red">{{ $errors->first('full_name') }}</span>
                            @endif
              </div> 
                    <div >
                    <lable  style="font-size:20px"> Email  ID : </lable>
                         <span style="color :red">*</span>
             
                        <input type= "text"  name ="email" placeholder="enter your email id " size = "25" value="{{ old('email') }}" required autocomplete="email" autofocus><br>
                          @if ($errors->has('email'))
                            <span style="color:red">{{ $errors->first('email') }}</span>
                            @endif
                    </div>
                    <div class="column1">
                         <lable  style="font-size:20px"> Password : </lable>
                          <span style="color :red">*</span>
             
                          <input type= "password"  name ="password" placeholder="enter password" size = "25" required><br>
                          @if ($errors->has('password'))
                            <span style="color:red">{{ $errors->first('password') }}</span>
                            @endif
                    </div>
                   <div class="column1">
                       <lable class="gender">Choose your Gender</lable>
                        <div class="gen_details">
                        <input type="radio" id="male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                <label for="male" class="male">Male</label>
                                <input type="radio" id="female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <label for="female" class="female">Female</label>
                                <input type="radio" id="others" name="gender" value="others" {{ old('gender') == 'others' ? 'checked' : '' }}>
                                <label for="others" class="others">Others</label><br>
                            

                        </div>
                        
                    </div>
                </div>
</div>

<div class="right">
              <!-- <div class="column2">
              <lable style="font-size:20px" >FullName : </lable>
                       <span style="color :red">*</span>
             
                      <input type= "text"  name ="full_name" placeholder="enter your full name " size = "25"value="{{ old('full_name') }}" required autocomplete="full_name" autofocus><br>
                      @if ($errors->has('full_name'))
                            <span style="color:red">{{ $errors->first('full_name') }}</span>
                            @endif
              </div> -->
              
              <div class="column2">
              <lable style="font-size:20px" >Phone Number : </lable>
                       <span style="color :red">*</span>
             
                      <input type= "text"  name ="phone_no" placeholder="enter your phone number " size = "25" value="{{ old('phone_no') }}" required autocomplete="phone_no" autofocus><br>
                      @if ($errors->has('phone_no'))
                         <span style="color:red">{{ $errors->first('phone_no') }}</span>
                        @endif
              </div>
              
              <div class="column2">
              
               <lable class="gender">Role :</lable>
                <span style="color:red">*</span>
                <select name="role" id="role">
                <option value="">Select your Role</option>
                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Client</option>
                <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Employee</option>
                </select><br>
                @if ($errors->has('role'))
                            <span style="color:red">{{ $errors->first('role') }}</span>
                            @endif
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