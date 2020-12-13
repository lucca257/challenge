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
    protected $orderService;

    /**
     * OrderItemService constructor.
     * @param OrderItemRepository $orderItemRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(OrderItemRepository $orderItemRepository, ProductRepository $productRepository, OrderService $orderService)
    {
        parent::__construct($orderItemRepository);
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
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
     * @param array $products
     * @param int $order_id
     * @return array
     */
    public function processProductItems(array $products, int $order_id): array
    {
        $totalPrice = 0;
        $save = [];
        foreach ($products as $item){
            $product = $this->validateProductExists($item["product"]);
            if (!$product) continue;
            $price = $this->calculateTotalPrice($item["product"], $item["quantaty"]);
            $save['items'] = parent::save([
                "product_id" => $item["product"],
                "quantity" => $item["quantaty"],
                "order_id" => $order_id,
                "price" => $price
            ]);
            $totalPrice += $price;
        }
        $this->orderService->update($order_id,[
            'total_price' => $totalPrice
        ]);
        $save['totalPrice'] = $totalPrice;
        return $save;
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
