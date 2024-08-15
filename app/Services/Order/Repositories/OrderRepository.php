<?php

namespace App\Services\Order\Repositories;

use App\Services\Order\Models\Order;
use App\Services\Product\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderRepository
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getAllOrders()
    {
        return $this->model->with('products')->get();
    }

    public function getOrderById(int $id)
    {
        return $this->model->with('products')->find($id);
    }

    public function checkIn(string $user_id)
    {
        return DB::transaction(function () use ($user_id) {
            return $this->model->create([
                'user_id' => $user_id,
            ]);
        });
    }

    public function add(Order $order, array $data)
    {
        $product = Product::find($data['product_id']);

        if (!$product) {
            throw new ModelNotFoundException("Product not found.");
        }

        if ($product->quantity < $data['quantity']) {
            throw new Exception("Insufficient quantity for product: {$product->name}");
        }

        DB::transaction(function () use ($order, $product, $data) {
            $product->decrement('quantity', $data['quantity']);

            $order->products()->attach($product->id, [
                'quantity' => $data['quantity'],
                'price' => (float) $product->price,
            ]);
        });
    }

    public function checkOut(Order $order)
    {
        return DB::transaction(function () use ($order) {
            $totalPrice = $order->products()->sum(DB::raw('order_product.price * order_product.quantity'));
            $order->update(['total_price' => $totalPrice]);

            return $order;
        });
    }
}
