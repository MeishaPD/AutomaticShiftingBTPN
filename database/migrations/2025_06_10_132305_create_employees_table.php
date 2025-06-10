<?php

use App\Enums\Gender;
use App\Enums\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nik')->unique();
            $table->string('name');
            $table->enum('gender', Gender::values())->comment('Employee gender');
            $table->string('religion');
            $table->enum('location', Location::values())->comment('Employee work location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
