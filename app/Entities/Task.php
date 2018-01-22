<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Task extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'event_id',
        'date',
        'description',
        'init',
        'end',
        'note',
        'state',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(){
        return $this->belongsTo(Event::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collaborators(){
        return $this->belongsToMany(Collaborator::class)
            ->withPivot('collaborator_id','allocation', 'accepted', 'init_time_correction', 'end_time_correction', 'normal_hour_value_total', 'extra_hour_value_total', 'confirm_allocation', 'validate_confirm_schedule', 'total_extra_hour', 'total_normal_hour', 'payment')
            ->withTimestamps();
    }

}
