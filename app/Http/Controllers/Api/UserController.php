<?php

namespace CodeDelivery\Http\Controllers\Api;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\UserRepository;
use Authorizer;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function authenticated(){
        $id = Authorizer::getResourceOwnerId();
        return $this->userRepository->skipPresenter(false)->find($id);
    }

    public function updateDeviceToken(Request $request){
        $id = Authorizer::getResourceOwnerId();
        return $this->userRepository->updateDeviceToken($id, $request->get('device_token'));
    }
}
