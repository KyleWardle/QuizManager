<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Log;

/**
 * App\Answer
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read mixed $created_at_display_date_time
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Answer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Answer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Answer withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $question_id
 * @property string $answer
 * @property int $position
 * @property int $is_correct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereIsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereUpdatedAt($value)
 */
class Answer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'answers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function getCreatedAtDisplayDateTimeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
