<?php

namespace App\Services\Product\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product\Facades\ProductFacade;
use App\Support\Traits\ApiResponseTrait;
use App\Services\Product\DTOs\ProductDTO;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        // Require authentication for all methods except index and show
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get all products",
     *     description="Retrieve a list of all products.",
     *     operationId="getProducts",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Products retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 required={"id", "name", "price"},
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Sample Product"),
     *                 @OA\Property(property="price", type="number", format="float", example=19.99)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = ProductFacade::getAll();
        return $this->successResponse($data, 'Products retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a new product",
     *     description="Create a new product with the provided details.",
     *     operationId="createProduct",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "price"},
     *             @OA\Property(property="name", type="string", example="Sample Product"),
     *             @OA\Property(property="price", type="number", format="float", example=19.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"id", "name", "price"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Sample Product"),
     *             @OA\Property(property="price", type="number", format="float", example=19.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid data")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $dto = ProductDTO::fromRequest($request->all());
            $data = ProductFacade::create($dto);

            return $this->successResponse($data, 'Product created successfully', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Invalid data', 422, json_decode($e->getPrevious()->getMessage(), true));
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get a specific product by ID",
     *     description="Retrieve details of a specific product by ID.",
     *     operationId="getProductById",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Product ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"id", "name", "price"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Sample Product"),
     *             @OA\Property(property="price", type="number", format="float", example=19.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $data = ProductFacade::getById($id);

        if (!$data) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse($data, 'Product retrieved successfully');
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update an existing product",
     *     description="Update the details of an existing product.",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Product ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "price"},
     *             @OA\Property(property="name", type="string", example="Updated Product"),
     *             @OA\Property(property="price", type="number", format="float", example=29.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"id", "name", "price"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated Product"),
     *             @OA\Property(property="price", type="number", format="float", example=29.99)
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
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $dto = ProductDTO::fromRequest($request->all());
            $data = ProductFacade::update($id, $dto);

            if (!$data) {
                return $this->errorResponse('Product not found', 404);
            }

            return $this->successResponse($data, 'Product updated successfully');
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Invalid data', 422, json_decode($e->getPrevious()->getMessage(), true));
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete a product",
     *     description="Delete a product by its ID.",
     *     operationId="deleteProduct",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Product ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found or unable to delete",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found or unable to delete")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $deleted = ProductFacade::delete($id);

        if (!$deleted) {
            return $this->errorResponse('Product not found or unable to delete', 404);
        }

        return $this->successResponse(null, 'Product deleted successfully');
    }
}
