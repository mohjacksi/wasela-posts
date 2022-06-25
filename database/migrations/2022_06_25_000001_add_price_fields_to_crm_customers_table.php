<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceFieldsToCrmCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('crm_customers', function (Blueprint $table) {
            $table->decimal('capital_default_price'  , 15, 0)->nullable();
            $table->decimal('other_default_price'  , 15, 0)->nullable();
        });
    }
}
