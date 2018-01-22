<?php

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByInitCriteriaCriteria
 * @package namespace App\Criteria;
 */
class FindByInitCriteriaCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('date_time_init', '>=', Carbon::parse(date('Y').'-1-1'))->where('date_time_init', '<=', Carbon::parse(date('Y').'-12-31'));

    }
}
