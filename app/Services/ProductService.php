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
     * @param int $totalItems
     * @return float|int
     */
    public function calculateTotalPrice(int $productId, int $totalItems): float
    {
        $product = parent::find($productId);
        return $totalItems * $product->price;
    }

    /**
     * @param int $product_id
     * @param float $quantity
     * @param bool $canceled
     * @return bool
     */
    public function updateQuantify(int $product_id, float $quantity, bool $canceled = false): bool
    {
        $product = parent::find($product_id);
        $new_quantity = $canceled ? $product->amount + $quantity : $product->amount - $quantity;
        return parent::update($product_id, [
            'amount' => $new_quantity
        ]);
    }
}
