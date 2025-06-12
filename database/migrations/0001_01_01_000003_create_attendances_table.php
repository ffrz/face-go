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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('date');
            $table->timestamp('check_in_time')->nullable();
            $table->string('check_in_photo')->nullable();
            $table->string('check_in_location')->nullable();
            $table->timestamp('check_out_time')->nullable();
            $table->string('check_out_photo')->nullable();
            $table->string('check_out_location')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'date']);
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');        
    }
};
