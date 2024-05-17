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
});


//Auth::routes();
Auth::routes(
             ['register' => false
        ]);


Route::get('/', function () {
    return view('login');
 })->name('login');