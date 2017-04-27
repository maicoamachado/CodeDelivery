<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use CodeDelivery\Models\Geo;
use CodeDelivery\Events\GetLocationDeliveryman;
use Authorizer;

class DeliverymanCheckoutController extends Controller
{
    private $repository;
    private $userRepository;
    private $orderService;

    public function __construct(
            OrderRepository $repository,
            UserRepository $userRepository,
            OrderService $orderService
        ){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
    }

    public function index(){
        
        $id = Authorizer::getResourceOwnerId();

        $orders = $this->repository->skipPresenter(false)->scopeQuery(function($query) use($id){
            return $query->where('user_deliveryman_id', $id);
        })->paginate();

        return $orders;
    }

    public function show($id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->repository
            ->skipPresenter(false)
            ->getByIdAndDeliveryman($id, $idDeliveryman);
    }

    public function updateStatus(Request $request, $id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->orderService->updateStatus($id, $idDeliveryman, $request->get('status'));
    }

    public function geo(Request $request, Geo $geo, $id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->repository->getByIdAndDeliveryman($id, $idDeliveryman);

        $geo->lat = $request->get('lat');
        $geo->long = $request->get('long');

        event(new GetLocationDeliveryman($geo, $order));

        return $geo;

    }
}
