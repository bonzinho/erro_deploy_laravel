<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SpaceTypeRepository;
use App\Entities\SpaceType;
use App\Validators\SpaceTypeValidator;

/**
 * Class SpaceTypeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SpaceTypeRepositoryEloquent extends BaseRepository implements SpaceTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SpaceType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SpaceTypeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
