<?php
// Get all order items
/**
 * @OA\Get(
 *     path="/order_items",
 *     tags={"order_items"},
 *     summary="Return all order items.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Response(response=200, description="List of order items.")
 * )
 */
Flight::route("GET /order_items", function(){
    Flight::json(Flight::order_item_service()->get_all());
});

// Get order items by order ID
/**
 * @OA\Get(
 *     path="/order_items/{order_id}",
 *     tags={"order_items"},
 *     summary="Fetch order items by Order ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="order_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Fetched order items by order ID.")
 * )
 */
Flight::route("GET /order_items/@order_id", function($order_id){
    Flight::json(Flight::order_item_service()->get_by_order_id($order_id));
});

// Get order item by ID
/**
 * @OA\Get(
 *     path="/order_item/{id}",
 *     tags={"order_items"},
 *     summary="Fetch individual order item by ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Fetched order item.")
 * )
 */
Flight::route("GET /order_item/@id", function($id){
    Flight::json(Flight::order_item_service()->get_by_id($id));
});

// Add order item
/**
 * @OA\Post(
 *     path="/order_item",
 *     tags={"order_items"},
 *     summary="Add a new order item.",
 *     description="Add new item to an order.",
 *     security={ {"ApiKey": {}} },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_id", "product_id", "quantity", "unit_price"},
 *             @OA\Property(property="order_id", type="integer", example=5),
 *             @OA\Property(property="product_id", type="integer", example=3),
 *             @OA\Property(property="quantity", type="integer", example=2),
 *             @OA\Property(property="unit_price", type="number", example=49.99)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order item added successfully.")
 * )
 */
Flight::route("POST /order_item", function(){
    $data = Flight::request()->data->getData();

    $required = ["order_id", "product_id", "quantity", "unit_price"];
    foreach ($required as $field) {
        if (!isset($data[$field])) {
            Flight::json(["error" => "Missing required field: $field"], 400);
            return;
        }
    }
    
    Flight::json([
        'message'=>"Order item added successfully!",
        'data'=>Flight::order_item_service()->add($data)
    ]);
});

// Update order item
/**
 * @OA\Patch(
 *     path="/order_item/{id}",
 *     tags={"order_items"},
 *     summary="Update order item.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="quantity", type="integer", example=4),
 *             @OA\Property(property="unit_price", type="number", example=59.99)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order item updated successfully.")
 * )
 */
Flight::route("PATCH /order_item/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message'=>"Order item updated successfully!",
        'data'=>Flight::order_item_service()->update($id, $data)
    ]);
});

// Delete order item
/**
 * @OA\Delete(
 *     path="/order_item/{id}",
 *     tags={"order_items"},
 *     summary="Delete an order item by ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Order item deleted successfully.")
 * )
 */
Flight::route("DELETE /order_item/@id", function($id){
    Flight::order_item_service()->delete($id);
    Flight::json(['message'=>"Order item deleted successfully!"]);
});
