<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuizAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->nullable()->default(null);
            $table->unsignedInteger('quiz_id')->nullable()->default(null);
            $table->datetime('quiz_start_time')->nullable()->default(null);
            $table->datetime('quiz_end_time')->nullable()->default(null);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('quiz_id')->references('id')->on('quizes');
        });

        Schema::create('quiz_attempt_answers', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('quiz_attempt_id')->nullable()->default(null);
            $table->unsignedInteger('question_id')->nullable()->default(null);
            $table->unsignedInteger('answer_id')->nullable()->default(null);
            $table->datetime('question_answer_time')->nullable()->default(null);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('quiz_attempt_id')->references('id')->on('quiz_attempts');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('answer_id')->references('id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
