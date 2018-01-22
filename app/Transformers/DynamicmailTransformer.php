<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Dynamicmail;

/**
 * Class DynamicmailTransformer
 * @package namespace App\Transformers;
 */
class DynamicmailTransformer extends TransformerAbstract
{

    /**
     * Transform the Dynamicmail entity
     * @param App\Entities\Dynamicmail $model
     *
     * @return array
     */
    public function transform(Dynamicmail $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
