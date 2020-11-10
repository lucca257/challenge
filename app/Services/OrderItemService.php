<?php


namespace App\Services;


use App\Repositories\OrderItemRepository;
use App\Repositories\ProductRepository;

/**
 * Class OrderItemService
 * @package App\Services
 */
class OrderItemService extends BaseService
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * OrderItemService constructor.
     * @param OrderItemRepository $orderItemRepository
     * @param ProductRepository $productRepository
     */
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
     * @param $product_id
     * @return mixed
     */
    public function validateProductExists($product_id)
    {
        return $this->productRepository->find($product_id);
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
