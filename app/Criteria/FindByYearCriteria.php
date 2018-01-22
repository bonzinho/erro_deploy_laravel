<?php

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByYearCriteria
 * @package namespace App\Criteria;
 */
class FindByYearCriteria implements CriteriaInterface
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
        return $model->where('created_at', '>=', Carbon::parse(date('Y').'-1-1'))->where('created_at', '<=', Carbon::parse(date('Y').'-12-31'));
    }
}
