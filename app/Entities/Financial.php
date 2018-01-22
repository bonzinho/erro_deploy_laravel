<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Financial extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'collaborator_id',
        'payment',
        'receipt',
        'extra_hours',
        'normal_hours',
        'pad'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collaborator(){
        return $this->belongsTo(Collaborator::class);
    }

    /**
     * @return string
     */
    public static function receiptDir(){
        return 'collaborator/receipts';
    }

}
