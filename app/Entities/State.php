<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class State extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name'];

    public function event(){
        return $this->hasMany(Event::class);
    }
}
