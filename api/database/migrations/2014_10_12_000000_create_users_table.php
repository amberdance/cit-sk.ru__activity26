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
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 14)->unique();
            $table->string('password');
            $table->string('ip_address');
            $table->boolean('policy_agree')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
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
