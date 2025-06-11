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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 40)->unique();
            $table->string('name', 255);
            $table->string('phone', 100);
            $table->string('address', 200);
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();

            $table->string('password');
            $table->datetime('last_login_datetime')->nullable();
            $table->string('last_activity_description')->default('');
            $table->datetime('last_activity_datetime')->nullable();
            $table->rememberToken();

            $table->datetime('created_datetime')->nullable();
            $table->datetime('updated_datetime')->nullable();
            $table->unsignedBigInteger('created_by_uid')->nullable();
            $table->unsignedBigInteger('updated_by_uid')->nullable();
            $table->foreign('created_by_uid')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by_uid')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('employee_password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('employee_sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('employee_account_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_sessions');
        Schema::dropIfExists('employee_password_reset_tokens');
        Schema::dropIfExists('employees');        
    }
};
