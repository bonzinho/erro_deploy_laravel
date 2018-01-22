<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Space;

/**
 * Class SpaceTransformer
 * @package namespace App\Transformers;
 */
class SpaceTransformer extends TransformerAbstract
{

    /**
     * Transform the \Space entity
     * @param \Space $model
     *
     * @return array
     */
    public function transform(Space $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
