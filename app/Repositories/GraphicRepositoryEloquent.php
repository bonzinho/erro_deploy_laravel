<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\GraphicRepository;
use App\Entities\Graphic;
use App\Validators\GraphicValidator;

/**
 * Class GraphicRepositoryEloquent
 * @package namespace App\Repositories;
 */
class GraphicRepositoryEloquent extends BaseRepository implements GraphicRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Graphic::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GraphicValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
