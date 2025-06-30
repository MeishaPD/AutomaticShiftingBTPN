<?php

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
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('leave_start');
            $table->date('leave_end');
            $table->timestamps();

            // unique constraint to prevent leave for the same employee on the same date
            $table->unique(['employee_id', 'leave_start']);

            // index for faster queries on leave_start and leave_date
            $table->index('leave_start');
            $table->index('leave_end');
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leaves');
    }
};
