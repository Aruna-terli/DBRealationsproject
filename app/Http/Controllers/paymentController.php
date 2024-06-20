<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\projects;
use App\Models\User;
use App\Events\PaymentSuccessfull;
use App\Models\Payment;
use Razorpay\Api\Api;

class paymentController extends Controller
{
    //
    public function index($id)
    {
       // $projects=projects::all();
      
       $paid_projects = Payment::where('user_id','!=',$id)->join('projects', 'projects.id', '=', 'payments.project_id')->get();
     
       $projects = projects::with('clients')->where('status','=',1)->get();
        

     
        return view("payment/project_details")->with(['projects'=>  $projects,'paid_projects'=>$paid_projects,'user_id'=>$id]);
       
    }
    public function project_buy($id,$user_id)
    {
        
        $project = projects::find($id);
        $user = User::find($user_id);
        return view("payment/payment_link")->with(['project' => $project, 'user' => $user]);

       
    }

    public function store(Request $request) {
        $input = $request->all();

        $api = new Api (env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        
        if(count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $payment = Payment::create([
                    'razor_pay_payment_id' => $response['id'],
                    'method' => $response['method'],
                    'currency' => $response['currency'],
                   'project_id'=>$response['notes']['product_id'],
                    'amount' => $response['amount']/100,
                    'data' => json_encode((array)$response),
                    'user_id'=>$response['notes']['user_id']

                ]);
                event(new PaymentSuccessfull($response));
                $user = User::where('email', $response['notes']['email'])->first();
 
                // $project = Projects::where('id',$response['notes']['product_id'])
                // ->where('project_name', $response['notes']['product_name'])
                // ->update(['payment_status' => 1]);
              if($user)
              {
                $user = $user->clientProjects()->attach($response['notes']['product_id']);
                
              }
               
            } catch(Exceptio $e) {
                return $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect('project_buy', ['id' => $response['notes']['user_id']])->back();
            }
        }
       // Session::put('success',('Payment Successful'));
       return redirect()->route('project_buy', ['id' => $response['notes']['user_id']])->with('success', 'Payment Successful');
    }
    
    public function sold_projects(){
       
        $projects =   Projects::with('clients')->get();
     
     foreach ($projects as $project) {
    $clients = [];
    $employees = [];
    $i = 0;

    foreach ($project->clients as $client) {
        if ($client->pivot->user_id != null) {
            $clients[$i] = User::where('id', $client->pivot->user_id)->where('role', 1)->get();
            $employees[$i] = User::where('id', $client->pivot->user_id)->where('role', 2)->get();
            $i++;
        }
    }

    // Assign the temporary arrays to the project object
    $project->clients_data = $clients;
    $project->employees_data = $employees;
}
    
     
        return view('projects/sold')->with('projects',$projects);
    }
}
