<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Space extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'cost',
        'host_number',
        'tec_number',
        'number_available',
        'state',
        'space_type_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events(){
        return $this->belongsToMany(Event::class)
            ->withPivot('quantity');
    }

    public function schedule(){
        return $this->hasOne(Schedule::class);
    }


}
