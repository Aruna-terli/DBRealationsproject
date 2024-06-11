<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="{{URL::to('css/style.css')}}">
</head>
<body>
  <form method ="post" action="{{route('signup')}}">  
  @csrf <!-- {{ csrf_field() }} -->
  <div class="container">
        
           <div class = "left">
              <h4>LOGIN</h4>
             <div class="eula">By logging in you agree to the ridiculously long terms that you didn't bother to read</div>

            </div>
            
            <div class = "right">
              <h1>WELCOME TO WORK PLACE</h1>
              <div class="col-md-5 mt-5">
              @if(Session::has('success'))
                <div class="alert alert-success" style="margin-left:30px">{{Session::get('success')}}</div>
              @endif   
              @if(Session::has('fail'))
             <div class="alert alert-danger"  style="margin-left:30px">{{Session::get('fail')}}</div>
              @endif  
         </div>
               <div class="login">
              
        
                  <div class="userid">
                      <lable >Enter Your Email ID: </lable>
                       <span style="color :white">*</span>
             
                      <input type= "text"  name ="email" placeholder="enter your email id " size = "25">
                      
               
                   </div>
                   <div class="userid">
                      <lable >Enter Your Password : </lable>
                        <span style="color :white">*</span>
             
                     <input type= "password" name="password" size= "25" placeholder="enter your password ">
               
                    </div>
                    <div class="buttoncenter"> 
                     <input type="submit" value="Login" class="button">
                    </div>
                    <div class="new_user" >
                        <lable style="margin-left:20px">New User?</lable>
                        <a href="{{route('register')}}"  style="color:red">Sign Up</a><br><br>
                    
                    
                      <!-- <a href="#" class="forgot_pass">Forgot Password</a> -->
                    
                </div>
            </div>
      
        </div>
    </form> 
     
  </body>
</html>