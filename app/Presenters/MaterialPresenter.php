<?php

namespace App\Presenters;

use App\Transformers\MaterialTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MaterialPresenter
 *
 * @package namespace App\Presenters;
 */
class MaterialPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MaterialTransformer();
    }
}
