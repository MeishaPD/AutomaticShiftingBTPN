<?php

use App\Enums\ShiftType;
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
        Schema::create('employee_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                ->constrained()
                ->onDelete('cascade');
            $table->enum('type', ShiftType::values());
            $table->date('shift_date');
            $table->timestamps();

            // unique constraint to prevent duplicate shifts for the same employee on the same date
            $table->unique(['employee_id', 'shift_date']);

            // index for faster queries on shift_date
            $table->index('shift_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_shifts');
    }
};
