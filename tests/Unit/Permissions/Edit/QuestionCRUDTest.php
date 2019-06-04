<?php

namespace Tests\Unit\Permissions\Edit;

use App\Answer;
use App\Question;
use App\Quiz;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionCRUDTest extends TestCase
{
    use DatabaseMigrations;
    protected $User;
    protected $Quiz;

    public function setUp()
    {
        parent::setUp();

        $this->User = factory(User::class)->state('edit')->create();

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

    public function testManageQuestions()
    {
        $response = $this->actingAs($this->User)
            ->get(route('manageQuestions', [$this->Quiz->id]));

        $response->assertStatus(200);
    }

    public function testNewQuestion()
    {
        $response = $this->actingAs($this->User)
            ->get(route('newQuestion', [$this->Quiz->id]));

        $response->assertStatus(200);
    }

    public function testSubmitNewQuestion()
    {
        $response = $this->actingAs($this->User)
            ->post(route('submitNewQuestion', [$this->Quiz->id]),
                [
                    'question' => 'test',
                    'answer' => ['test 1', 'test 2'],
                    'correct' => ['on'],
                ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('manageQuestions', $this->Quiz->id));
    }

    public function testEditQuestion()
    {
        $response = $this->actingAs($this->User)
            ->get(route('editQuestion', [$this->Quiz->id, $this->Quiz->Questions->first()->id]));

        $response->assertStatus(200);
    }

    public function testSubmitEditQuestion()
    {
        $response = $this->actingAs($this->User)
            ->post(route('submitEditQuestion', [$this->Quiz->id, $this->Quiz->Questions->first()->id]),
                [
                    'question' => 'test',
                    'answer' => ['test 1', 'test 2'],
                    'correct' => ['on'],
                ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('manageQuestions', $this->Quiz->id));
    }

    public function testDeleteQuestion()
    {
        $response = $this->actingAs($this->User)
            ->get(route('deleteQuestion', [$this->Quiz->id, $this->Quiz->Questions->first()->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('manageQuestions', $this->Quiz->id));
    }
}
