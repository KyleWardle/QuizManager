<?php

use App\Answer;
use App\Question;
use App\Quiz;
use App\QuizAttempt;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    return [
        'title' => $faker->text(),
        'description' => $faker->text(),
        'pass_amount' => random_int(3,6)
    ];
});

$factory->define(Question::class, function (Faker $faker) {
    return [
        'question' => $faker->text(),
        'position' => random_int(1,10)
    ];
});

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'answer' => $faker->text(20),
        'is_correct' => random_int(0,1),
        'position' => random_int(1,10)
    ];
});

$factory->define(QuizAttempt::class, function (Faker $faker) {
    return [
        'quiz_start_time' => Carbon::now(),
    ];
});