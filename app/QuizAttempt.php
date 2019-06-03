<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Log;

/**
 * App\QuizAttempt
 *
 * @property-read \App\Quiz $Quiz
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuizAttemptAnswer[] $QuizAttemptAnswers
 * @property-read \App\User $User
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read mixed $correct_questions_count
 * @property-read mixed $created_at_display_date_time
 * @property-read mixed $has_passed
 * @property-read mixed $time_taken
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\QuizAttempt onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\QuizAttempt withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\QuizAttempt withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $user_id
 * @property int|null $quiz_id
 * @property \Illuminate\Support\Carbon|null $quiz_start_time
 * @property \Illuminate\Support\Carbon|null $quiz_end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt whereQuizEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt whereQuizStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuizAttempt whereUserId($value)
 */
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
        return $this->belongsTo(Quiz::class, 'quiz_id')->withTrashed();
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
        if ($this->quiz_end_time === null) {
            return 'Incomplete';
        }

        return $this->quiz_start_time->diffAsCarbonInterval($this->quiz_end_time)->forHumans();

    }
}
