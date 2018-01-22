<?php

namespace App\Presenters;

use App\Transformers\CollaboratorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CollaboratorPresenter
 *
 * @package namespace App\Presenters;
 */
class CollaboratorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CollaboratorTransformer();
    }
}
