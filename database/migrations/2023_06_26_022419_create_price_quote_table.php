<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
      * Run the migrations.
      *
      * @return void
      */
     public function up()
     {
         Schema::create('price_quote', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('project_request_id');
             $table->string('project_complexity');
             $table->integer('estimate_time');
             $table->text('additional_services');
             $table->decimal('total_amount', 10, 2);
             $table->timestamps();

             $table->foreign('project_request_id')->references('id')->on('project_requests');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('price_quote');
     }
};
