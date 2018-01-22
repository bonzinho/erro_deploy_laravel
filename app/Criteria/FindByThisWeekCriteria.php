<?php

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByThisWeekCriteria
 * @package namespace App\Criteria;
 */
class FindByThisWeekCriteria implements CriteriaInterface
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
        $today = Carbon::today()->format('Y-m-d');
        $nextWeek = Carbon::today()->addDays(7);
        return $model->where('date_time_init',  '>=', $today)
            ->where('date_time_end', '<=', $nextWeek);
    }
}
