<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DynamicmailRepository;
use App\Entities\Dynamicmail;
use App\Validators\DynamicmailValidator;

/**
 * Class DynamicmailRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DynamicmailRepositoryEloquent extends BaseRepository implements DynamicmailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Dynamicmail::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return DynamicmailValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
