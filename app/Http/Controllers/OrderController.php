<?php

namespace App\Http\Controllers;


use App\Services\OrderItemService;
use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends BaseController
{
    private $orderService, $orderItemService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     * @param OrderItemService $orderItemService
     */
    public function __construct(OrderService $orderService, OrderItemService $orderItemService)
    {
        $this->orderService = $orderService;
        $this->orderItemService = $orderItemService;
        parent::__construct($orderService);
    }

    /**
     * @return Application|Factory|View
     */
    public function home(): View
    {
        return view('order.index');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $order = $this->orderService->save([
                "client_id" => $request->get('client_id'),
                "status" => $request->get('status')
            ]);
            $save = $this->orderItemService->save([
                "product_id" => $request->get('product_id'),
                "quantity" => $request->get('quantity'),
                "order_id" => $order->id
            ]);
            return $this->responseApi(["order" => $order, "item" => $save], 'Dados criados com sucesso');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->responseApi([], 'Falha interna ao criar dados', false, 500);
        }
    }
}
