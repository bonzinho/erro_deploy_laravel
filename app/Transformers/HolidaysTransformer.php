<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Holidays;

/**
 * Class HolidaysTransformer
 * @package namespace App\Transformers;
 */
class HolidaysTransformer extends TransformerAbstract
{

    /**
     * Transform the Holidays entity
     * @param App\Entities\Holidays $model
     *
     * @return array
     */
    public function transform(Holidays $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
