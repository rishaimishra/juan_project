<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('company_name'); // Company Name
            $table->string('tin')->nullable(); // Tax Identification Number
            $table->string('license_num'); // License Number
            $table->string('insurance_num'); // Insurance Number
            $table->string('address'); // Address
            $table->string('postal_code'); // Postal Code
            $table->string('city'); // City
            $table->string('country'); // Country
            $table->string('state'); // State/Province
            $table->string('representative_name'); // Representative Name
            $table->string('last_name'); // Representative Last Name
            $table->string('identity_document')->nullable(); // Identity Document (DNI)
            $table->string('company_telephone'); // Company Telephone
            $table->string('mobile_num'); // Mobile Telephone
            $table->string('position')->nullable(); // Position
            $table->json('company_type')->nullable();; // Company Type
            $table->integer('geographic_area'); // Geographic Area
            $table->string('email'); // Email
            $table->string('password'); // Password
            $table->json('states')->nullable();
            $table->json('countries')->nullable();
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
        Schema::dropIfExists('contractors');
    }
}
