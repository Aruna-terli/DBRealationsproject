<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
</head>
<body>
<form method ="post" action="{{route('assignEmploye')}}">  
  @csrf <!-- {{ csrf_field() }} -->
  @method('POST')

    <div class="reg">
       
        <div class="reg_form">
        
        <div class="row" style="padding-left:35px">    
          <h2>Assign  Employe To Project</h2>
            <div class="col-md-5">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif   
                @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif  
            </div>
           
           
            
            <div>
              <!-- Dropdown for employees -->
              <label style="font-size: 20px">Select Employee:</label>
                        <select name="employe_id" >
                            @foreach($employes as $employe)
                                <option value="{{ $employe->id }}" >{{ $employe->name }}</option>
                            @endforeach
                        </select><br>

                        <!-- Dropdown for projects -->
                        <label style="font-size: 20px">Select Project:</label>
                        <select name="project_id">
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                   
             
            
            
          <input type="submit" value="submit" class="btn_reg">
        </div>
    </div>
</div>

 </form>
 
</html>   