<?php

namespace App\Presenters;

use App\Transformers\FinancialTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FinancialPresenter
 *
 * @package namespace App\Presenters;
 */
class FinancialPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FinancialTransformer();
    }
}
