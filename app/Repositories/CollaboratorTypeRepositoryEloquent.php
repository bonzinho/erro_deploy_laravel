<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CollaboratorTypeRepository;
use App\Entities\CollaboratorType;
use App\Validators\CollaboratorTypeValidator;

/**
 * Class CollaboratorTypeRepositoryEloquentclear
 * @package namespace App\Repositories;
 */
class CollaboratorTypeRepositoryEloquent extends BaseRepository implements CollaboratorTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CollaboratorType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CollaboratorTypeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
