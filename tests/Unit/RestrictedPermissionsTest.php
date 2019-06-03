<?php

namespace Tests\Unit;

use App\Answer;
use App\Question;
use App\Quiz;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestrictedPermissionsTest extends TestCase
{
    use DatabaseMigrations;
    protected $User;
    protected $Quiz;

    public function setUp()
    {
        parent::setUp();

        $this->User = User::create([
            'name' => 'Test User',
            'email' => 'testemail@test.com',
            'password' => '123',
            'role_id' => 1
        ]);

        // Need to use factories
        $this->Quiz = Quiz::create([
            'name' => 'Quiz Test',
            'description' => 'Test 123',
            'pass_amount' => 2
        ]);

        for ($i = 0; $i > 3; $i++) {
            $Question = Question::create([
                'question' => 'Test 123',
                'position' => $i + 1,
                'quiz_id' => $this->Quiz->id
            ]);
            for ($a = 0; $a > 3; $a++) {
                Answer::create([
                    'answer' => 'Test 123',
                    'position' => $a + 1,
                    'question_id' => $Question->id,
                    'is_correct' => true
                ]);
            }

        }
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

    public function testTakeQuiz()
    {
        $response = $this->actingAs($this->User)
            ->get(route('startQuiz', [$this->Quiz->id]));

        $response->assertStatus(200);
    }
}
