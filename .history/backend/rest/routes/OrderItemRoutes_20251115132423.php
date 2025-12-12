<?php

/**
 * @OA\Post(path="/order-item", tags={"OrderItem"}, summary="Add product to order")
 */
Flight::route('POST /order-item', function() {
    Flight::json(Flight::order_item_service()->add(Flight::request()->data->getData()));
});
