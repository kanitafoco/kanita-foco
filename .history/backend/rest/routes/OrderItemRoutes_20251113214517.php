<?php

/**
 * @OA\Post(
 *     path="/orderitem",
 *     tags={"OrderItem"},
 *     summary="Add item to order",
 *     @OA\RequestBody(@OA\JsonContent(
 *        required={"order_id", "product_id", "quantity"},
 *        @OA\Property(property="order_id", type="integer"),
 *        @OA\Property(property="product_id", type="integer"),
 *        @OA\Property(property="quantity", type="integer")
 *     )),
 *     @OA\Response(response=200, description="Order item added")
 * )
 */
Flight::route("POST /orderitem", function(){
    Flight::json(Flight::order_item_service()->add(Flight::request()->data->getData()));
});
