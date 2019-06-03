<?php

namespace App;

use App\Traits\DeleteButton;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Log;

/**
 * App\Quiz
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $Questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read mixed $created_at_display_date_time
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Quiz onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Quiz withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Quiz withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $pass_amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz wherePassAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quiz whereUpdatedAt($value)
 */
class Quiz extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use DeleteButton;

    protected $table = 'quizes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'pass_amount'
    ];

    public function Questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }


    public function getCreatedAtDisplayDateTimeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
