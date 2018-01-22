<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AudiovisualRepository;
use App\Entities\Audiovisual;
use App\Validators\AudiovisualValidator;

/**
 * Class AudiovisualRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AudiovisualRepositoryEloquent extends BaseRepository implements AudiovisualRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Audiovisual::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AudiovisualValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
