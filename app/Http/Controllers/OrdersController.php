<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\StatusOrdersRepository;
use CodeDelivery\Http\Requests\AdminOrderRequest;

class OrdersController extends Controller
{
    private $repository;
    private $userRepository;
    private $statusOrdersRepository;

    public function __construct(OrderRepository $repository, UserRepository $userRepository, StatusOrdersRepository $statusOrdersRepository){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->statusOrdersRepository = $statusOrdersRepository;
    }
    public function index(){
        $orders = $this->repository->paginate();

        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id){
        $order = $this->repository->find($id);
        $deliveryman = $this->userRepository->roleLists('deliveryman');
        $status = $this->statusOrdersRepository->getStatusOrdersLists();
        return view('admin.orders.edit', compact('order', 'deliveryman', 'status'));
    }

    public function update(AdminOrderRequest $request, $id){
        $data = $request->all();
        $this->repository->update($data, $id);
        return redirect()->route('admin.orders.index');
    }
}
