<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id', 'customer_fk_6634848')->references('id')->on('crm_customers');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_6635160')->references('id')->on('post_statuses');
        });
    }
}
