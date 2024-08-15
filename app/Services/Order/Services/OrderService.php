<?php

namespace App\Services\Order\Services;

use App\Services\Order\Repositories\OrderRepository;
use App\Services\Order\DTOs\OrderDTO;
use App\Services\Order\Contracts\OrderContract;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderContract
{
    protected $orderRepo;
    protected $order;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function getAll()
    {
        return $this->orderRepo->getAllOrders();
    }

    public function getById(int $id)
    {
        return $this->orderRepo->getOrderById($id);
    }

    public function createOrder(OrderDTO $dto)
    {
        DB::beginTransaction();

        try {
            $order = $this->orderRepo->checkIn($dto->user_id);

            foreach ($dto->products as $product) {
                $this->orderRepo->add($order, $product);
            }

            $order = $this->orderRepo->checkOut($order);

            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
