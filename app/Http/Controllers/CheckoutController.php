<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use CodeDelivery\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
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
        
        $clientId = $this->userRepository->find(\Auth::user()->id)->client->id;
        $orders = $this->repository->scopeQuery(function($query) use($clientId){
            return $query->where('client_id', $clientId);
        })->paginate();

        return view('customer.order.index', compact('orders'));
    }

    public function create(){
        $products = $this->productRepository->list();
        return view('customer.order.create', compact('products'));
    }

    public function store(CheckoutRequest $request){
        $data = $request->all();
        $clientId = $this->userRepository->find(\Auth::user()->id)->client->id;
        $data['client_id'] = $clientId;
        $this->orderService->create($data);

        return redirect()->route('customer.order.index');

    }
}
