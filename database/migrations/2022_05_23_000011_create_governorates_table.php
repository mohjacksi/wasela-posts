<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovernoratesTable extends Migration
{
    public function up()
    {
        Schema::create('governorates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->decimal('default_price'  , 15, 0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
