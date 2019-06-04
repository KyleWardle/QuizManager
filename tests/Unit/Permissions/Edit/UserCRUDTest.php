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

class UserCRUDTest extends TestCase
{
    use DatabaseMigrations;
    protected $User;
    protected $Quiz;
    protected $OtherUser;

    public function setUp()
    {
        parent::setUp();

        $this->User = factory(User::class)->state('edit')->create();
        $this->OtherUser = factory(User::class)->create();

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

    public function testManageUsers()
    {
        $response = $this->actingAs($this->User)
            ->get(route('manageUsers'));

        $response->assertStatus(200);
    }

    public function testNewUser()
    {
        $response = $this->actingAs($this->User)
            ->get(route('newUser'));

        $response->assertStatus(200);
    }

    public function testSubmitNewUser()
    {
        $response = $this->actingAs($this->User)
            ->post(route('createUser'),
                [
                    'name' => 'Name',
                    'email' => 'email_test@test.com',
                    'role_id' => 1,
                    'password' => 'test12312',
                    'password_confirmation' => 'test12312'
                ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('manageUsers'));
    }

    public function testEditUser()
    {
        $response = $this->actingAs($this->User)
            ->get(route('editUser', [$this->OtherUser->id]));

        $response->assertStatus(200);
    }

    public function testUpdateUser()
    {
        $response = $this->actingAs($this->User)
            ->patch(route('updateUser', [$this->OtherUser->id]),
                [
                    'name' => 'Name',
                    'role_id' => 1,
                ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('manageUsers'));
    }

    public function testDeleteUser()
    {
        $response = $this->actingAs($this->User)
            ->delete(route('deleteUser', [$this->OtherUser->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('manageUsers'));
    }

}
