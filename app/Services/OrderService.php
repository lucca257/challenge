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

    private function calculateTotalPrice(int $productId, int $totalItens){
        $product = $this->productRepository->find($productId);
        return $totalItens * $product->price;
    }
}
