<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Support;

/**
 * Class SupportTransformer
 * @package namespace App\Transformers;
 */
class SupportTransformer extends TransformerAbstract
{

    /**
     * Transform the \Support entity
     * @param \Support $model
     *
     * @return array
     */
    public function transform(Support $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
