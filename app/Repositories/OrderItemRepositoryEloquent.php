<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\OrderitemRepository;
use CodeDelivery\Models\Orderitem;
use CodeDelivery\Validators\OrderitemValidator;

/**
 * Class OrderitemRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderItemRepositoryEloquent extends BaseRepository implements OrderitemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Orderitem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
