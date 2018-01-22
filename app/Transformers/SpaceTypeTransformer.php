<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\SpaceType;

/**
 * Class SpaceTypeTransformer
 * @package namespace App\Transformers;
 */
class SpaceTypeTransformer extends TransformerAbstract
{

    /**
     * Transform the \SpaceType entity
     * @param \SpaceType $model
     *
     * @return array
     */
    public function transform(SpaceType $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
