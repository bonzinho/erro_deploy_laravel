<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Expense;

/**
 * Class ExpenseTransformer
 * @package namespace App\Transformers;
 */
class ExpenseTransformer extends TransformerAbstract
{

    /**
     * Transform the Expense entity
     * @param App\Entities\Expense $model
     *
     * @return array
     */
    public function transform(Expense $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
