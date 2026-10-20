<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            $table->string('jurisdiction_code', 10)->unique();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('cp', 4); // codigo postal
            $table->string('full_cp', 10)->nullable(); // codigo postal completo
            $table->unsignedBigInteger('province_id');

            $table->foreign('province_id')->references('id')->on('provinces');
        });

        Schema::create('marital_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->unique();
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->unique();
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('fiscal_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('professions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 70)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
        });

        Schema::create('business_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
        });

        Schema::create('occupational_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
        });

        Schema::create('residence_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('marital_statuses');
        Schema::dropIfExists('genders');
        Schema::dropIfExists('fiscal_conditions');
        Schema::dropIfExists('professions');
        Schema::dropIfExists('business_activities');
        Schema::dropIfExists('occupational_statuses');
        Schema::dropIfExists('residence_types');
    }
};
