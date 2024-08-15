<?php

namespace App\Services\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Auth\DTOs\UserDTO;
use App\Services\Auth\DTOs\AuthDTO;
use App\Services\Auth\Facades\AuthFacade;
use App\Support\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * AuthController handles user authentication related endpoints.
 */
class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api')->only('register');
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     description="Create a new user and return a JWT token.",
     *     operationId="register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
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
    public function register(Request $request)
    {
        try {
            $dto = UserDTO::fromRequest($request->all());
            $user = AuthFacade::register($dto);
            $token = JWTAuth::fromUser($user);

            return $this->successResponse(['token' => $token], 'User registered successfully', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Invalid data', 422, json_decode($e->getPrevious()->getMessage(), true));
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     description="Authenticate user and return a JWT token.",
     *     operationId="login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
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
    public function login(Request $request)
    {
        try {
            $dto = AuthDTO::fromRequest($request->all());
            $token = AuthFacade::login($dto);

            if (!$token) {
                return $this->errorResponse('Unauthorized', 401);
            }

            return $this->successResponse(['token' => $token], 'Login successful');
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Invalid data', 422, json_decode($e->getPrevious()->getMessage(), true));
        }
    }
}
