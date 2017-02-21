<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\StatusOrdersRepository;
use CodeDelivery\Models\StatusOrders;
use CodeDelivery\Validators\StatusOrdersValidator;

/**
 * Class StatusOrdersRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class StatusOrdersRepositoryEloquent extends BaseRepository implements StatusOrdersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StatusOrders::class;
    }

    public function getStatusOrdersLists(){
        return $this->model->lists('name', 'id');
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
