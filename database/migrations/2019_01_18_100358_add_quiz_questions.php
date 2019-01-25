<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuizQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quiz_id')->unsigned();
            $table->text('question');
            $table->integer('position')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('quiz_id')->references('id')->on('quizes');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->text('answer');
            $table->integer('position')->unsigned();
            $table->boolean('is_correct')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('question_id')->references('id')->on('questions');
        });

        // Schema::create('user_answers', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('quiz_id')->unsigned();
        //     $table->integer('question_id')->unsigned();
        //     $table->integer('answer_id')->unsigned();
        //     $table->text('answer');
        //     $table->boolean('is_correct')->default(0);
        //     $table->timestamps();
        //     $table->softDeletes();
        //
        //     $table->foreign('quiz_id')->references('id')->on('quizes');
        //     $table->foreign('question_id')->references('id')->on('questions');
        //     $table->foreign('answer_id')->references('id')->on('answers');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_answers');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
    }
}
