<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Expense extends Model implements Transformable
{
    use TransformableTrait;

    const GESTAO_TECNICA = 0; // despesas com hospedeiros e tecnicos
    const GESTAO_AGENDA= 1; // despesas várias com tudo o que o evento tem

    protected $fillable = [
        'event_id',
        'description',
        'value',
        'group'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(){
        return $this->belongsTo(Event::class);
    }

}
