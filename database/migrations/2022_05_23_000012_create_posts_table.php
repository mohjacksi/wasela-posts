<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('barcode')->unique();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone_number');
            $table->string('delivery_address');
            $table->decimal('sender_total'  , 15, 0);
            $table->decimal('delivery_price' , 15,0);
            $table->decimal('customer_invoice_total'  , 15, 0);
            $table->longText('notes')->nullable();
            $table->string('type')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
