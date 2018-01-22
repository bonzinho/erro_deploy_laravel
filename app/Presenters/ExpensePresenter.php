<?php

namespace App\Presenters;

use App\Transformers\ExpenseTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ExpensePresenter
 *
 * @package namespace App\Presenters;
 */
class ExpensePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ExpenseTransformer();
    }
}
