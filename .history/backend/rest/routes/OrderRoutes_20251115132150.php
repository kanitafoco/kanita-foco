<?php

/**
 * @OA\Get(
 *     path="/order",
 *     tags={"Order"},
 *     summary="Get all orders",
 *     @OA\Response(response=200, description="List of orders")
 * )
 */
Flight::route('GET /order', function() {
    Flight::json(Flight::order_service()->get_all());
});

/**
 * @OA\Get(
 *     path="/order/{id}",
 *     tags={"Order"},
 *     summary="Get order by ID",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Order details"),
 *     @OA\Response(response=404, description="Order not found")
 * )
 */
Flight::route('GET /order/@id', function($id) {
    Flight::json(Flight::order_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/order",
 *     tags={"Order"},
 *     summary="Create new order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id"},
 *             @OA\Property(property="user_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Order created")
 * )
 */
Flight::route('POST /order', function() {
    Flight::json(Flight::order_service()->add(Flight::request()->data->getData()));
});
