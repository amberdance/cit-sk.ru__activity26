<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 38)->unique();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('patronymic')->nullable();
            $table->integer('district_id');
            $table->string('address');
            $table->string('birthday');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('phone', 14)->unique();
            $table->string('ip_address');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->integer('points')->default(0);
            $table->boolean('is_associated')->default(false);
            $table->string('associate_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
