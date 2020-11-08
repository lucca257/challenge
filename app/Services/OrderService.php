<?php


namespace App\Services;


use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class OrderService extends BaseService
{
    protected $orderRepository, $productRepository, $orderItemRepository;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, OrderItemRepository $orderItemRepository)
    {
        parent::__construct($orderRepository);
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    /**
     * return all orders with relationships
     * @return object
     */
    public function all(): object
    {
        return $this->orderRepository->findByRelations('oderItem');
    }

    /**
     * calculate the total price of product
     * @param int $productId
     * @param int $totalItens
     * @return float|int
     */
    private function calculateTotalPrice(int $productId, int $totalItens){
        $product = $this->productRepository->find($productId);
        return $totalItens * $product->price;
    }
}
