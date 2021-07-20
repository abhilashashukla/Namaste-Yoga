<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackResponsesRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_responses_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->integer('feedback_questions_id');
            $table->integer('rating');
            $table->string('rating_description','255');   
            $table->softDeletes();         
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
        Schema::dropIfExists('feedback_responses_ratings');
    }
}
