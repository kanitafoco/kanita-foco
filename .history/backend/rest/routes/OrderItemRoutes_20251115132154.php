<?php

/**
 * @OA\Post(
 *     path="/order-item",
 *     tags={"OrderItem"},
 *     summary="Add product to order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_id","product_id","quantity"},
 *             @OA\Property(property="order_id", type="integer"),
 *             @OA\Property(property="product_id", type="integer"),
 *             @OA\Property(property="quantity", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Order item added")
 * )
 */
Flight::route('POST /order-item', function() {
    Flight::json(Flight::order_item_service()->add(Flight::request()->data->getData()));
});
