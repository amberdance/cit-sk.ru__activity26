<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('poll_id');
            $table->integer('sort')->default(500);
            $table->string('label');
            $table->string('description')->nullable();
            $table->string('type')->default('radio');
            $table->boolean('has_own_variant')->default(false);
            $table->boolean('is_required')->default(true);
            $table->integer('max_allowed')->default(20);
            $table->integer('min_allowed')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poll_questions');
    }
};
