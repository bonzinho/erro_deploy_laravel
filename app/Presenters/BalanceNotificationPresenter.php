<?php

namespace App\Presenters;

use App\Transformers\BalanceNotificationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BalanceNotificationPresenter
 *
 * @package namespace App\Presenters;
 */
class BalanceNotificationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BalanceNotificationTransformer();
    }
}
