<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razor_pay_payment_id');
            $table->string('method');
            $table->string('currency');
            
            $table->integer('user_id');
            $table->integer('project_id');
            // $table->enum('project_type',['e-commernce','health','gaming','LMS','others'])->nullable();
           
            $table->string('amount'); 
            $table->longText('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
