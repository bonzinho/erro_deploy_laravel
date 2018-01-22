<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Schedule extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'event_id',
        'date',
        'init',
        'end',
        'turno',
        'space_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function space(){
        return $this->belongsTo(Space::class);
    }

}
