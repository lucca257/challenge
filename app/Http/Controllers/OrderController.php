<?php

namespace App\Http\Controllers;


use App\Services\OrderItemService;
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
     * @param OrderItemService $orderItemService
     */
    public function __construct(OrderItemService $orderItemService)
    {
        parent::__construct($orderItemService);
    }

    /**
     * @return Application|Factory|View
     */
    public function home(): View
    {
        return view('order.index');
    }
}
