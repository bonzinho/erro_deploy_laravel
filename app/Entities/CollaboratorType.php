<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CollaboratorType extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'tag'
    ];

    public function collaborators(){
        return $this->hasMany(Collaborator::class);
    }

}
