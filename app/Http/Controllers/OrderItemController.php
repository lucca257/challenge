<?php

namespace App\Http\Controllers;

use App\Services\OrderItemService;

/**
 * Class OrderItemController
 * @package App\Http\Controllers
 */
class OrderItemController extends BaseController
{
    public function __construct(OrderItemService $orderItem)
    {
        parent::__construct($orderItem);
    }
}
