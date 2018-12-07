<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Log;

class Quiz extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'quizes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'description'
    ];


    public function getCreatedAtDisplayDateTimeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
