<?php

namespace App\Http\Controllers;


use App\Services\OrderItemService;
use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends BaseController
{
    /**
     * OrderController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        parent::__construct($orderService);
    }

    /**
     * @return Application|Factory|View
     */
    public function home(): View
    {
        return view('order.index');
    }
}
