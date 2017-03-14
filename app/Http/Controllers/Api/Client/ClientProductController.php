<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\ProductRepository;

class ClientProductController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $repository){
        $this->repository = $repository;
    }

    public function index(){
        
        $products = $this->repository->skipPresenter(false)->all();
        return $products;
    }

}
