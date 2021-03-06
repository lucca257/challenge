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
    protected $orderService;
    protected $productService;

    /**
     * OrderItemService constructor.
     * @param OrderItemRepository $orderItemRepository
     * @param OrderService $orderService
     * @param ProductService $productService
     */
    public function __construct(OrderItemRepository $orderItemRepository, OrderService $orderService, ProductService $productService)
    {
        parent::__construct($orderItemRepository);
        $this->orderService = $orderService;
        $this->productService = $productService;
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
            $product = $this->productService->find($item["product"]);
            if (!$product) continue;
            $price = $this->productService->calculateTotalPrice($item["product"], $item["quantaty"]);
            $save['items'] = parent::save([
                "product_id" => $item["product"],
                "quantity" => $item["quantaty"],
                "order_id" => $order_id,
                "price" => $price
            ]);
            $totalPrice += $price;
            $this->productService->updateQuantify($item["product"], $item["quantaty"]);
        }
        $this->orderService->update($order_id,[
            'total_price' => $totalPrice
        ]);
        $save['totalPrice'] = $totalPrice;
        return $save;
    }
}
