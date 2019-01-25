<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Log;

class QuizAttemptAnswer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'quiz_attempt_answers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'question_answer_time'
    ];

    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'answer_id',
        'question_answer_time'
    ];


    public function QuizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'quiz_attempt_id');
    }

    public function Question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function Answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function getCreatedAtDisplayDateTimeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
