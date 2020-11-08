<?php


namespace App\Services;


use App\Repositories\OrderItemRepository;
use App\Repositories\ProductRepository;

class OrderItemService extends BaseService
{
    protected $productRepository;

    public function __construct(OrderItemRepository $orderItemRepository, ProductRepository $productRepository)
    {
        parent::__construct($orderItemRepository);
        $this->productRepository = $productRepository;
    }

    /**
     * @param array $attributes
     * @return object
     */
    public function save(array $attributes): object
    {
        $attributes['price'] = $this->calculateTotalPrice($attributes["product_id"], $attributes["quantity"]);
        return parent::save($attributes);
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
