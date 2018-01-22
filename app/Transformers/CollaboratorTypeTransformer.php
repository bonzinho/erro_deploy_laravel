<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CollaboratorType;

/**
 * Class CollaboratorTypeTransformer
 * @package namespace App\Transformers;
 */
class CollaboratorTypeTransformer extends TransformerAbstract
{

    /**
     * Transform the \CollaboratorType entity
     * @param \CollaboratorType $model
     *
     * @return array
     */
    public function transform(CollaboratorType $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
