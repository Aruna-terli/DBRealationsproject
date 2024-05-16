<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumnProjectIdPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('payments', function (Blueprint $table) {
           
            $table->enum('project_type',['e-commernce','health','gaming','LMS','others'])->after('user_email');
            $table->string('project_name')->before('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            
            $table->dropColumn(['project_type',  'project_name']);
        });
    }
}
