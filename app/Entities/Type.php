<?php

//Tipo de enventos externos ou outra coisa


namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Type extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'state',
        'collaborator_pay_hour',
        'collaborator_pay_extra_hour',
        'collaborator_audit_pay_period',
        'collaborator_audit_pay_extra_hour',
        'collaborator_audit_all_day',
        'discount'
    ];

    public function events(){
        return $this->belongsTo(Event::class);
    }
}
