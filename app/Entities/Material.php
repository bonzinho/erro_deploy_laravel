<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Material extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Events(){
        return $this->belongsToMany(Event::class)->withPivot('quantity');
    }

}
