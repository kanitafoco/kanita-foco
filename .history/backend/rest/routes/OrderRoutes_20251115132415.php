<?php

/**
 * @OA\Get(path="/order", tags={"Order"}, summary="Get all orders")
 */
Flight::route('GET /order', function() {
    Flight::json(Flight::order_service()->get_all());
});

/**
 * @OA\Get(path="/order/{id}", tags={"Order"}, summary="Get order by ID")
 */
Flight::route('GET /order/@id', function($id) {
    Flight::json(Flight::order_service()->get_by_id($id));
});

/**
 * @OA\Post(path="/order", tags={"Order"}, summary="Create order")
 */
Flight::route('POST /order', function() {
    Flight::json(Flight::order_service()->add(Flight::request()->data->getData()));
});
