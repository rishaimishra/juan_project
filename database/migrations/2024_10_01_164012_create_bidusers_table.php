<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidusers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('address');
            $table->string('postal_code');
            $table->string('city');
            $table->string('country');  // assuming country as a string or code
            $table->string('state');    // assuming state as a string or code
            $table->string('identity_document')->nullable(); // path for uploaded document
            $table->string('home_telephone');
            $table->string('mobile_num');
            $table->string('association')->nullable(); // optional
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('term_accept')->default(0);
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
        Schema::dropIfExists('bidusers');
    }
}
