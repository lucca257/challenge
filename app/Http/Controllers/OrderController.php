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
            $products = $request->get('products');
            $status = $request->get('status');
            $client_id = $request->get('client_id');

            $order = $this->orderService->save([
                "client_id" => $client_id,
                "status" => $status
            ]);

            $orderItems = $this->orderItemService->processProductItems($products, $order->id);
            $response = ["order" => $order, "item" => $orderItems["items"], "total_price" => $orderItems['totalPrice']];
            if(empty($orderItems)){
                DB::rollBack();
                return $this->responseApi([], 'nenhum item foi cadastrado', false, 500);
            }
            DB::commit();
            return $this->responseApi($response, 'Dados criados com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return $this->responseApi([], 'Falha interna ao criar dados', false, 500);
        }
    }
}
