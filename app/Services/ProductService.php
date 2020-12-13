<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService extends BaseService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct($productRepository);
    }

    /**
     * calculate the total price of product
     * @param int $productId
     * @param int $totalItens
     * @return float|int
     */
    public function calculateTotalPrice(int $productId, int $totalItens){
        $product = $this->productRepository->find($productId);
        return $totalItens * $product->price;
    }
}
