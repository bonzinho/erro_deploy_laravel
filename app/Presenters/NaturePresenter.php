<?php

namespace App\Presenters;

use App\Transformers\NatureTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NaturePresenter
 *
 * @package namespace App\Presenters;
 */
class NaturePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NatureTransformer();
    }
}
