<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Http\Requests\AdminClientRequest;

class ClientsController extends Controller
{
    private $repository;
    private $userRepository;
    public function __construct(ClientRepository $repository, UserRepository $userRepository){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }
    public function index(){
        $clients = $this->repository->paginate();
        return view('admin.clients.index', compact('clients'));
    }

    public function create(){
         return view('admin.clients.create');
    }

    public function store(AdminClientRequest $request){
        $data = $request->all();
        $data['user']['password'] = bcrypt(123456);
        $user = $this->userRepository->create($data['user']);
        $data['user_id'] = $user->id;
        $this->repository->create($data);

        return redirect()->route('admin.clients.index');
    }

    public function edit($id){
        $client = $this->repository->find($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(AdminClientRequest $request, $id){
        $data = $request->all();
        $this->repository->update($data, $id);
        $userId = $this->repository->find($id, ['user_id'])->user_id;
        $this->userRepository->update($data['user'], $userId);

        return redirect()->route('admin.clients.index');
    }

    public function destroy($id){
        $userId = $this->repository->find($id, ['user_id'])->user_id;
        $this->repository->delete($id);
        $this->userRepository->delete($userId);
        
        return redirect()->route('admin.clients.index');
    }
}
