<?php

namespace App\Http\Controllers;


use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends BaseController
{
    private $orderService, $orderItemService, $productService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     * @param OrderItemService $orderItemService
     * @param ProductService $productService
     */
    public function __construct(OrderService $orderService, OrderItemService $orderItemService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->orderItemService = $orderItemService;
        $this->productService = $productService;
        parent::__construct($orderService);
    }

    /**
     * @return Application|Factory|View
     */
    public function home(): View
    {
        return view('order.index');
    }

    /**
     * saving order and itens
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $order_request = $request->get('order');
            $item_request = $request->get('item');
            $order = $this->orderService->save([
                "client_id" => $order_request["client_id"],
                "status" => $order_request["status"]
            ]);

            $save = [];
            foreach ($item_request as $item){
                $product = $this->productService->find($item["product_id"]);
                if (!$product) continue;
                $save[] = $this->orderItemService->save([
                    "product_id" => $item["product_id"],
                    "quantity" => $item["product_id"],
                    "order_id" => $order->id
                ]);
            }
            $response = ["order" => $order, "item" => $save];
            if(empty($save)){
                DB::rollBack();
                return $this->responseApi([], 'nenhum item foi cadastrado', false, 500);
            }
            DB::commit();
            return $this->responseApi($response, 'Dados criados com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->responseApi([], 'Falha interna ao criar dados', false, 500);
        }
    }
}
