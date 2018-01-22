<?php

namespace App\Presenters;

use App\Transformers\DynamicmailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DynamicmailPresenter
 *
 * @package namespace App\Presenters;
 */
class DynamicmailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DynamicmailTransformer();
    }
}
