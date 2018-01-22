<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Recipe;

/**
 * Class RecipeTransformer
 * @package namespace App\Transformers;
 */
class RecipeTransformer extends TransformerAbstract
{

    /**
     * Transform the Recipe entity
     * @param App\Entities\Recipe $model
     *
     * @return array
     */
    public function transform(Recipe $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
