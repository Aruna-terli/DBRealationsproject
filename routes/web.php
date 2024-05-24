<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::post("/login_data",'App\Http\Controllers\LoginController@login')->name('login_data');
Route::post('/savedata', 'App\Http\Controllers\LoginController@save')->name('savedata');
Route::get('/register','App\Http\Controllers\LoginController@register')->name('register');
Route::post('/signup','App\Http\Controllers\LoginController@authenticate')->name('signup');

Route::middleware(['auth'])->group(function () {

Route::get('/home', [App\Http\Controllers\LoginController::class, 'admindashboard'])->name('home');
Route::get('/clientdashboard', [App\Http\Controllers\LoginController::class, 'clientdashboard'])->name('clientdashboard');
Route::get('/employedashboard', [App\Http\Controllers\LoginController::class, 'employedashboard'])->name('employedashboard');   
Route::get('/assignEmployeview',[App\Http\Controllers\clientController::class,'assignEmployeview'])->name('assignEmployeview');
Route::post('/assignEmploye',[App\Http\Controllers\clientController::class,'assignEmploye'])->name('assignEmploye');
Route::get('/project_buy/{id}',[App\Http\Controllers\paymentController::class, 'index'])->name('project_buy');
Route::resource('projects', 'App\Http\Controllers\projectController');
Route::get('projects_sold',[App\Http\Controllers\paymentController::class, 'sold_projects'])->name('projects_sold');
Route::resource('clients', 'App\Http\Controllers\clientController');
Route::get('employeprojects/{id}',[App\Http\Controllers\EmployeController::class,'employeprojects'])->name('employeprojects');
Route::resource('employes', 'App\Http\Controllers\EmployeController');

Route::get('/project_link/{id}/{user_id}',[App\Http\Controllers\paymentController::class,'project_buy'])->name('project_link');

Route::post('razorpay_payment',[App\Http\Controllers\paymentController::class,'store'])->name('razorpay_payment');
Route::get('chat',[App\Http\Controllers\ChatController::class,'index'])->name('chat');
Route::post('sendmessage',[App\Http\Controllers\ChatController::class,'sendmessage'])->name('sendmessage');
Route::post('sendGroupMessage',[App\Http\Controllers\ChatController::class,'sendGroupMessage'])->name('sendGroupMessage');


Route::get('/group/show', 'App\Http\Controllers\ChatController@show')->name('group.show');
Route::get('/group/create', 'App\Http\Controllers\GroupController@create_form')->name('group.create');
Route::post('/group/create', 'App\Http\Controllers\GroupController@create');
Route::get('/group/join/{group_id}', 'App\Http\Controllers\GroupController@join_form')->name('group.join');
Route::post('/group/join', 'App\Http\Controllers\GroupController@join');
Route::get('/group/edit/{id}', 'App\Http\Controllers\GroupController@edit')->name('group.edit');
Route::post('/group/update/{id}', 'App\Http\Controllers\GroupController@update');
Route::get('/group/delete/{id}', 'App\Http\Controllers\GroupController@deleteGroup')->name('group.delete');
Route::get('/group/members_list/{id}', 'App\Http\Controllers\GroupController@members_list')->name('users_in_group');
Route::get('/remove_user/{id}/{user_id}', 'App\Http\Controllers\GroupController@remove_user');
// Route::get('fetchMessages/{userId}',[App\Http\Controllers\ChatController::class,'fetchMessages'])->name('fetchMessages');
});


//Auth::routes();
Auth::routes(
             ['register' => false
        ]);


Route::get('/', function () {
    return view('login');
 })->name('login');