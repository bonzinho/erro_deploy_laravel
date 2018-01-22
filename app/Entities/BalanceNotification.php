<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BalanceNotification extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'event_id',
        'token',
        'read_at',
    ];


    public function event(){
        return $this->belongsTo(Event::class);
    }


    /**
     * @param $event_id
     * @return string
     */
    public static function createToken($event_id){
        return str_random(16).time().$event_id;
    }


}
