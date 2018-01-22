<?php

namespace App\Presenters;

use App\Transformers\SupportTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SupportPresenter
 *
 * @package namespace App\Presenters;
 */
class SupportPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SupportTransformer();
    }
}
