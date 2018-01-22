<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Graphic;

/**
 * Class GraphicTransformer
 * @package namespace App\Transformers;
 */
class GraphicTransformer extends TransformerAbstract
{

    /**
     * Transform the \Graphic entity
     * @param \Graphic $model
     *
     * @return array
     */
    public function transform(Graphic $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
