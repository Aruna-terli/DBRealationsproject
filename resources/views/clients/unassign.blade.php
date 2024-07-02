<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="{{URL::to('css/registration.css')}}">
</head>
<body>
<form method ="post" action="{{route('unassignEmploye')}}">  
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
                           
                                <option value="{{ $employe[0]['id'] }}"  >{{ $employe[0]['name'] }}</option>
                            
                        </select><br>

                        <!-- Dropdown for projects -->
                        <label style="font-size: 20px">Select Project:</label>
                        <select name="project_id">
                            @foreach($projects as $project)
                            
                                <option value="{{ $project->id }}">{{ $project->name}}</option>
                               
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-top: 20px;">
          <a href="{{ route('employes.index') }}" class="btn_link" style="margin-left:25%;padding:1% 4%">Back</a>  
          <input type="submit" value="Submit" class="btn_update"style="padding:1% 4%" >
        </div>
             
            
            
          
        </div>
    </div>
</div>

 </form>
 
</html>   