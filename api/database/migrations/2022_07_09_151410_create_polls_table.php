<?php

use App\Lib\Thumbnail;
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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->integer('sort')->default(500);
            $table->integer('points')->default(20);
            $table->integer('category_id');
            $table->string('label');
            $table->longText('description')->nullable();
            $table->string('image')->default('images/polls/image_default.png');
            $table->string('thumbnail')->default(Thumbnail::createSmall(public_path() . '/assets/images/polls/image_default.png'));
            $table->boolean('is_active')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->timestamp('active_from')->nullable();
            $table->timestamp('active_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polls');
    }
};
