<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('doc_id');
            $table->foreign('doc_id')
              ->references('id')->on('docs')
              ->onDelete('cascade');
            $table->string('name');  
            $table->string('type');  
            $table->string('validation');
            $table->string('sample');  
            $table->boolean('required')->default(0);
            $table->string('default');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bodies');
    }
}
