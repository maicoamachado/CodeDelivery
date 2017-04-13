<?php
namespace CodeDelivery\Services;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Models\Order;
use Dmitrovskiy\IonicPush\PushProcessor;

class OrderService{
    
    private $orderRepository, $cupomRepository, $productRepository;
    
    public function __construct(
        OrderRepository $orderRepository,
        CupomRepository $cupomRepository, 
        ProductRepository $productRepository,
        PushProcessor $pushProcessor
    ){
        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
        $this->pushProcessor = $pushProcessor;
    }

    public function create(array $data){

        \DB::beginTransaction();
        try{

            if(isset($data['cupom_id'])){
                unset($data['cupom_id']);
            }

            $data['status_id'] = 1;
            if(isset($data['cupom_code'])){
                $cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
                $data['cupom_id'] = $cupom->id;
                $cupom->used = 1;
                $cupom->save();
                unset($data['cupom_code']);
            }

            $items = $data['items'];
            unset($data['items']);

            $order = $this->orderRepository->create($data);
            $total = 0;

            foreach($items as $item){
                $item['price'] = $this->productRepository->find($item['product_id'])->price;
                $order->items()->create($item);
                $total += $item['price'] * $item['qtd'];
            }

            $order->total = $total;
            if(isset($cupom)){
                $order->total = $total - $cupom->value;
            }
            $order->save();

            \DB::commit();
            
            return $order;
        }catch(\Exception $e){
           \DB::rollback();
            throw $e;
        }
        
    }

    public function update(array $data, $id){
        
    }

    public function updateStatus($id, $idDeliveryman, $status){
        $order = $this->orderRepository->getByIdAndDeliveryman($id, $idDeliveryman);
        $order->status_id = $status;

        switch((int)$order->status_id){
            case 3: // em transporte
                if((int)$order->status_id == 3 && !$order->hash){
                    $order->hash = md5((new \DateTime())->getTimestamp());
                }
                $order->save();
                break;
            case 4: //entregue ao destinatário
                $user = $order->client->user;
                $order->save();
                $this->pushProcessor->notify([$user->device_token],[
                    'alert' => "Seu pedido #{$order->id} acabou de ser entregue"
                ]);
            break;
        }
        return $order;
    }
}