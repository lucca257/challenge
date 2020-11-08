<?php


namespace App\Services;


use App\Repositories\OrderItemRepository;

class OrderItemService extends BaseService
{
    protected $orderItemRepository;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
        parent::__construct($orderItemRepository);
    }
}
