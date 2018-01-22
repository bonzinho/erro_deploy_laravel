<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BalanceNotificationRepository;
use App\Entities\BalanceNotification;
use App\Validators\BalanceNotificationValidator;

/**
 * Class BalanceNotificationRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BalanceNotificationRepositoryEloquent extends BaseRepository implements BalanceNotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BalanceNotification::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
