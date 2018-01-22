<?php

namespace App\Presenters;

use App\Transformers\HolidaysTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class HolidaysPresenter
 *
 * @package namespace App\Presenters;
 */
class HolidaysPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new HolidaysTransformer();
    }
}
