<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_validations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('verify_code', false, true);
            $table->integer('user_id');
            $table->integer('error_code');
            $table->integer('message_id');
            $table->string('type', 50)->default('call');
            $table->integer('attempts')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_validations');
    }
}
