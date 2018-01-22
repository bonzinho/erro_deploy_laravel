<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Dynamicmail extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'from',
        'subject',
        'attatch1',
        'attatch2',
        'attatch3',
        'attatch4',
        'message',
    ];



    /**
     * @return string
     */
    public static function attatchDir(){
        return 'dynamic-email/attachs';
    }

}
