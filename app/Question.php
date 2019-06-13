<?php

namespace App;

use App\Traits\DeleteButton;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Log;

/**
 * App\Question
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Answer[] $Answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read mixed $created_at_display_date_time
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Question onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Question withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $quiz_id
 * @property string $question
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereUpdatedAt($value)
 */
class Question extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use DeleteButton;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'questions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function getCreatedAtDisplayDateTimeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function render_delete_button($delete_url, $field_name = 'name', $password_confirm = false)
    {
        $model_id = $this->id;
        $model = "App\\".class_basename($this);
        return view('layouts.delete_button', compact('delete_url', 'field_name', 'password_confirm', 'model_id', 'model'));
    }
}
