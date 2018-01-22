<?php

namespace App\Presenters;

use App\Transformers\SpaceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SpacePresenter
 *
 * @package namespace App\Presenters;
 */
class SpacePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SpaceTransformer();
    }
}
