<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Nature;

/**
 * Class NatureTransformer
 * @package namespace App\Transformers;
 */
class NatureTransformer extends TransformerAbstract
{

    /**
     * Transform the \Nature entity
     * @param \Nature $model
     *
     * @return array
     */
    public function transform(Nature $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
