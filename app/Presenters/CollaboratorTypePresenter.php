<?php

namespace App\Presenters;

use App\Transformers\CollaboratorTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CollaboratorTypePresenter
 *
 * @package namespace App\Presenters;
 */
class CollaboratorTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CollaboratorTypeTransformer();
    }
}
