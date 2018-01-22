<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Audiovisual extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name', 'price'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events(){
        return $this->belongsToMany(Event::class, 'event_audiovisual')
            ->withPivot('quantity');
    }

}
