<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Financial;

/**
 * Class FinancialTransformer
 * @package namespace App\Transformers;
 */
class FinancialTransformer extends TransformerAbstract
{

    /**
     * Transform the Financial entity
     * @param App\Entities\Financial $model
     *
     * @return array
     */
    public function transform(Financial $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
