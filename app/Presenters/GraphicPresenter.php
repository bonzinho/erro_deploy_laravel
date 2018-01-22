<?php

namespace App\Presenters;

use App\Transformers\GraphicTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GraphicPresenter
 *
 * @package namespace App\Presenters;
 */
class GraphicPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GraphicTransformer();
    }
}
