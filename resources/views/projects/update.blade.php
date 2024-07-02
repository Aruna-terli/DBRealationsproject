<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
</head>
<body>
<form method ="post" action="{{route('projects.update',$project['id'])}}">  
  @csrf <!-- {{ csrf_field() }} -->
  @method('PUT')

    <div class="reg">
       
        <div class="reg_form">
        <a href="{{route('projects.index')}}" style="float:right;margin:5% 5%;font-size:20px" title="Back">
        <i class="fas fa-arrow-left"></i>
        </a>
        <div class="row" style="padding-left:35px">    
          <h2>Update project</h2>
            <div class="col-md-5">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif   
                @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif  
            </div>
            <div >
              <lable style="font-size:20px" >Project Name : </lable>
                       <span style="color :red">*</span>
             
                      <input type= "text" style="width:60%;margin-left:5%"  name ="project_name" placeholder="Enter Project name " size = "25"value="{{ $project['name'] }}" ><br>
                      @if ($errors->has('project_name'))
                            <span style="color:red;margin-left:25%">{{ $errors->first('project_name') }}</span>
                            @endif
            </div>
              
            <div >
              <lable style="font-size:20px" >Price for project: </lable>
                       <span style="color :red">*</span>
             
                      <input type= "number" style="width:60%;margin-left:3%"  name ="price" placeholder="Enter price " size = "25" value="{{ $project['amount'] }}" autocomplete="price" autofocus><br>
                      @if ($errors->has('price'))
                         <span style="color:red;margin-left:25%">{{ $errors->first('price') }}</span>
                        @endif
            </div>
             
            <div >
                
             
               <lable  style="font-size: 20px;margin: 0% 0%;">Project Type :</lable>
                <span style="color:red">*</span>
                <select name="project_type"style="width:60%;margin-left:6%"  id="project_type">
                   
                   @if($project['type'] != '')
                
                   <option value="{{$project['type']}}">{{$project['type']}}</option> 
                  @endif
                   <option  value="e-commernce">e-commerce</option>
                    <option  value="health">health</option>
                    <option value="gaming">Gaming</option>
                    <option value="LMS">LMS</option>
                    <option value="others">others</option>
                </select><br>
                @if ($errors->has('project_type'))
                            <span style="color:red;margin-left:25%">{{ $errors->first('project_type') }}</span>
                            @endif
            </div>
            <div>
                <lable style="font-size:20px" >Description: </lable>
                       <span style="color :red">*</span>
             
                      <textarea style="width:60%;margin-left:8%;margin-top:3%"  name ="description" rows="5" cols ="50" placeholder="Describe project "   >
                      {{ $project['description'] }}
                     </textarea><br><br>
                      @if ($errors->has('description'))
                         <span style="color:red;margin-left:25%">{{ $errors->first('description') }}</span>
                        @endif
          
            </div>
            <div style="margin-top:10px">
          
              <a class="btn_link" style="margin-bottom: 9%;margin-left:30%;padding:1% 4%"  href="{{ route('projects.index') }}">Back</a>
          
            <input type="submit" style="padding:1% 4%" value="Update" class="btn_update">
          </div>
        </div>
    </div>
</div>

 </form>
 
</html>   