<?php

namespace Tests\Unit\Permissions\View;

use App\Answer;
use App\Question;
use App\Quiz;
use App\QuizAttempt;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizAttemptTest extends TestCase
{
    use DatabaseMigrations;
    protected $User;
    protected $Quiz;
    protected $QuizAttempt;

    public function setUp()
    {
        parent::setUp();

        $this->User = factory(User::class)->state('view')->create();

        // Need to use factories
        $this->Quiz = factory(Quiz::class, 1)->create()->each(function ($Quiz) {
            $Quiz->Questions()->saveMany(factory(Question::class, random_int(6,9))->create([
                'quiz_id' => $Quiz->id,
            ])->each(function ($Question) {
                $Question->Answers()->saveMany(factory(Answer::class, random_int(4,7))->create([
                    'question_id' => $Question->id
                ]));
            }));

            $Quiz->QuizAttempts()->save(factory(QuizAttempt::class)->create([
                'quiz_id' => $Quiz->id,
                'user_id' => $this->User->id,
            ]));
        })->first();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testStartQuiz()
    {
        $response = $this->actingAs($this->User)
            ->get(route('startQuiz', [$this->Quiz->id]));

        $response->assertStatus(200);
    }

    public function testSubmitStartQuiz()
    {
        $response = $this->actingAs($this->User)
            ->get(route('submitStartQuiz', [$this->Quiz->id]));

        $Attempt = QuizAttempt::get()->last();
        $Quiz = Quiz::get()->last();

        $response->assertStatus(302);
        $response->assertRedirect(route('takeQuiz', [$Quiz->id, $Attempt->id]));
    }

    public function testTakeQuiz()
    {
        $response = $this->actingAs($this->User)
            ->get(route('takeQuiz', [$this->Quiz->id, $this->Quiz->QuizAttempts->first()->id]));

        $response->assertStatus(200);
    }

    public function testGrabNextQuestion()
    {
        $response = $this->actingAs($this->User)
            ->post(route('grabNextQuestion', [$this->Quiz->id, $this->Quiz->QuizAttempts->first()->id]));

        $response->assertStatus(200);
    }

    public function testSaveQuizAnswer()
    {
        $response = $this->actingAs($this->User)
            ->post(route('saveQuizAnswer', [$this->Quiz->id, $this->Quiz->QuizAttempts->first()->id]), [
                'question_id' => $this->Quiz->Questions->first()->id,
                'answer_id' => $this->Quiz->Questions->first()->Answers()->first()->id
            ]);

        $response->assertStatus(200);
    }

    public function testQuizSummary()
    {
        $response = $this->actingAs($this->User)
            ->get(route('quizSummary', [$this->Quiz->id, $this->Quiz->QuizAttempts->first()->id]));

        $response->assertStatus(200);
    }

}
