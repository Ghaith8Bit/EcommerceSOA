<?php

namespace App\Services\Order\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Order\Facades\OrderFacade;
use App\Support\Traits\ApiResponseTrait;
use App\Services\Order\DTOs\OrderDTO;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * OrderController handles order-related endpoints.
 */
class OrderController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api')->except('store');
    }

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get all orders",
     *     description="Retrieve a list of all orders.",
     *     operationId="getOrders",
     *     tags={"Orders"},
     *     @OA\Response(
     *         response=200,
     *         description="Orders retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 required={"id", "product_name", "quantity", "price"},
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="product_name", type="string", example="Sample Product"),
     *                 @OA\Property(property="quantity", type="integer", example=10),
     *                 @OA\Property(property="price", type="number", format="float", example=99.99)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve orders",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to retrieve orders")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $orders = OrderFacade::getAll();
            return $this->successResponse($orders, 'Orders retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve orders', 500, ['message' => $e->getMessage()]);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="Get a specific order by ID",
     *     description="Retrieve details of a specific order by ID.",
     *     operationId="getOrderById",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Order ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"id", "product_name", "quantity", "price"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="product_name", type="string", example="Sample Product"),
     *             @OA\Property(property="quantity", type="integer", example=10),
     *             @OA\Property(property="price", type="number", format="float", example=99.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $order = OrderFacade::getById($id);

        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }

        return $this->successResponse($order, 'Order retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     description="Place a new order with one or multiple products.",
     *     operationId="createOrder",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"product_name", "quantity", "price"},
     *             @OA\Property(property="product_name", type="string", example="Sample Product"),
     *             @OA\Property(property="quantity", type="integer", example=10),
     *             @OA\Property(property="price", type="number", format="float", example=99.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"id", "product_name", "quantity", "price"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="product_name", type="string", example="Sample Product"),
     *             @OA\Property(property="quantity", type="integer", example=10),
     *             @OA\Property(property="price", type="number", format="float", example=99.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid data")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $dto = OrderDTO::fromRequest($request->all());
            $order = OrderFacade::createOrder($dto);

            return $this->successResponse($order, 'Order created successfully', 201);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Not found', 404, ['message' => $e->getMessage()]);
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Invalid data', 422, json_decode($e->getPrevious()->getMessage(), true));
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500, ['message' => $e->getMessage()]);
        }
    }
}
