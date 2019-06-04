<?php

namespace Tests\Unit\Permissions\Restricted;

use App\Answer;
use App\Question;
use App\Quiz;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizCRUDTest extends TestCase
{
    use DatabaseMigrations;
    protected $User;
    protected $Quiz;

    public function setUp()
    {
        parent::setUp();

        $this->User = factory(User::class)->create();

        // Need to use factories
        $this->Quiz = factory(Quiz::class, 1)->create()->each(function ($Quiz) {
            $Quiz->Questions()->saveMany(factory(Question::class, random_int(6,9))->create([
                'quiz_id' => $Quiz->id,
            ])->each(function ($Question) {
                $Question->Answers()->saveMany(factory(Answer::class, random_int(4,7))->create([
                    'question_id' => $Question->id
                ]));
            }));
        })->first();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testHome()
    {
        $response = $this->actingAs($this->User)
            ->get(route('home'));

        $response->assertStatus(200);
    }

    public function testCreateQuiz()
    {
        $response = $this->actingAs($this->User)
            ->get(route('createQuiz'));

        $response->assertStatus(403);
    }

    public function testSubmitCreateQuiz()
    {
        $response = $this->actingAs($this->User)
            ->post(route('submitCreateQuiz'));

        $response->assertStatus(403);
    }

    public function testEditQuiz()
    {
        $response = $this->actingAs($this->User)
            ->get(route('editQuiz', [$this->Quiz->id]));

        $response->assertStatus(403);
    }

    public function testSubmitEditQuiz()
    {
        $response = $this->actingAs($this->User)
            ->post(route('submitEditQuiz', [$this->Quiz->id]));

        $response->assertStatus(403);
    }

    public function testDeleteQuiz()
    {
        $response = $this->actingAs($this->User)
            ->delete(route('deleteQuiz', [$this->Quiz->id]));

        $response->assertStatus(403);
    }

    public function testQuizAttempts()
    {
        $response = $this->actingAs($this->User)
            ->get(route('quizAttempts', [$this->Quiz->id]));

        $response->assertStatus(403);
    }
}
