<?php


namespace App\Repositories;


use App\Models\Order;

class OrderRepository extends BaseRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        parent::__construct($order);
    }

    /**
     * find order and our itens
     * @param int $id
     * @return object
     */
    public function find(int $id): object
    {
        return $this->order->with('oderItem')->find($id);
    }
}
