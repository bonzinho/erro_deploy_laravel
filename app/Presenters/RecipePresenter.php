<?php

namespace App\Presenters;

use App\Transformers\RecipeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RecipePresenter
 *
 * @package namespace App\Presenters;
 */
class RecipePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RecipeTransformer();
    }
}
