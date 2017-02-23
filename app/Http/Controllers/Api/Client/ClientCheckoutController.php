<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use Authorizer;
class ClientCheckoutController extends Controller
{
    private $repository;
    private $userRepository;
    private $productRepository;
    private $orderService;

    public function __construct(
            OrderRepository $repository,
            UserRepository $userRepository,
            ProductRepository $productRepository,
            OrderService $orderService
        ){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
    }

    public function index(){
        
        $id = Authorizer::getResourceOwnerId();
        $user = $this->userRepository->find($id);

        $clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->repository->with(['items'])->scopeQuery(function($query) use($clientId){
            return $query->where('client_id', $clientId);
        })->paginate();

        return $orders;
    }

    public function create(){
        $products = $this->productRepository->list();
        return view('customer.order.create', compact('products'));
    }

    public function store(Request $request){
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $obj = $this->orderService->create($data);

        $order = $this->repository->with(['items'])->find($obj->id);
        
        return $order;
    }

    public function show($id){

        $order = $this->repository->with(['client', 'items', 'cupom'])->find($id);
        $order->items->each(function($item){
            $item->product;
        });
        return $order;
    }
}
