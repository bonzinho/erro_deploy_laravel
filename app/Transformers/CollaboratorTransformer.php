<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Collaborator;

/**
 * Class CollaboratorTransformer
 * @package namespace App\Transformers;
 */
class CollaboratorTransformer extends TransformerAbstract
{

    /**
     * Transform the \Collaborator entity
     * @param \Collaborator $model
     *
     * @return array
     */
    public function transform(Collaborator $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
