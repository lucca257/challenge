<?php


namespace App\Services;


use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class OrderService extends BaseService
{
    protected $orderRepository, $productRepository, $orderItemRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        parent::__construct($orderRepository);
        $this->orderRepository = $orderRepository;
    }

    /**
     * return all orders with relationships
     * @return object
     */
    public function all(): object
    {
        return $this->orderRepository->findByRelations('oderItem');
    }
}
