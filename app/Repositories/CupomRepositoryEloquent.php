<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Models\Cupom;
use CodeDelivery\Validators\CupomValidator;
use CodeDelivery\Presenters\CupomPresenter;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
/**
 * Class CupomRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class CupomRepositoryEloquent extends BaseRepository implements CupomRepository
{
    protected $skipPresenter = true;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cupom::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(){
        return CupomPresenter::class;
    }

    public function findBycode($code){
        $result = $this->model->where('code', $code)->where('used', 0)->first();

        if($result){
            return $this->parserResult($result);
        }

        throw (new ModelNotFoundException)->setModel(get_class($this->model));

    }
}
