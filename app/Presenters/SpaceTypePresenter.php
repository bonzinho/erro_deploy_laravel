<?php

namespace App\Presenters;

use App\Transformers\SpaceTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SpaceTypePresenter
 *
 * @package namespace App\Presenters;
 */
class SpaceTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SpaceTypeTransformer();
    }
}
