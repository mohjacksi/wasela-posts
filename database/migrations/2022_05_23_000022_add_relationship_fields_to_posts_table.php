<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->foreign('sender_id', 'sender_fk_6635491')->references('id')->on('crm_customers');
            $table->unsignedBigInteger('governorate_id')->nullable();
            $table->foreign('governorate_id', 'governorate_fk_6634775')->references('id')->on('governorates');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_6634776')->references('id')->on('cities');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_6635160')->references('id')->on('post_statuses');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id', 'invoice_fk_6639397')->references('id')->on('invoices');
        });
    }
}
