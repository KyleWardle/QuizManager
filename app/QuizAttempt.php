<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Log;

class QuizAttempt extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'quiz_attempts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'quiz_start_time',
        'quiz_end_time'
    ];

    protected $fillable = [
        'user_id',
        'quiz_id',
        'quiz_start_time',
        'quiz_end_time'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function QuizAttemptAnswers()
    {
        return $this->hasMany(QuizAttemptAnswer::class, 'quiz_attempt_id');
    }

    public function getCreatedAtDisplayDateTimeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getCorrectQuestionsCountAttribute()
    {
        $correct_count = 0;

        foreach ($this->QuizAttemptAnswers as $answer_attempt) {
            if ($answer_attempt->Answer->is_correct) {
                $correct_count++;
            }
        }

        return $correct_count;
    }

    public function getHasPassedAttribute()
    {
        return $this->correct_questions_count >= $this->Quiz->pass_amount ? true : false;
    }

    public function getTimeTakenAttribute()
    {
        return $this->quiz_start_time->diffAsCarbonInterval($this->quiz_end_time)->forHumans();

    }
}
