<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Log;

/**
 * App\QuizAttemptAnswer
 *
 * @property-read \App\Answer $Answer
 * @property-read \App\Question $Question
 * @property-read \App\QuizAttempt $QuizAttempt
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read mixed $created_at_display_date_time
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\QuizAttemptAnswer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\QuizAttemptAnswer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\QuizAttemptAnswer withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $quiz_attempt_id
 * @property int|null $question_id
 * @property int|null $answer_id
 * @property \Illuminate\Support\Carbon|null $question_answer_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer whereQuestionAnswerTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer whereQuizAttemptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttemptAnswer whereUpdatedAt($value)
 */
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

    public function QuestionWithDeleted()
    {
        return $this->belongsTo(Question::class, 'question_id')->withTrashed();
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
