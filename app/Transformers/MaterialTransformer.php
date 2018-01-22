<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Material;

/**
 * Class MaterialTransformer
 * @package namespace App\Transformers;
 */
class MaterialTransformer extends TransformerAbstract
{

    /**
     * Transform the \Material entity
     * @param \Material $model
     *
     * @return array
     */
    public function transform(Material $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
