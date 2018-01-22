<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BalanceNotification;

/**
 * Class BalanceNotificationTransformer
 * @package namespace App\Transformers;
 */
class BalanceNotificationTransformer extends TransformerAbstract
{

    /**
     * Transform the BalanceNotification entity
     * @param App\Entities\BalanceNotification $model
     *
     * @return array
     */
    public function transform(BalanceNotification $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
