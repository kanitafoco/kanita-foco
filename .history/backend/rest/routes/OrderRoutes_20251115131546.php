<?php
// Get all orders
/**
 * @OA\Get(
 *     path="/order",
 *     tags={"orders"},
 *     summary="Return all orders.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Response(response=200, description="List of orders."),
 *     @OA\Response(response=500, description="Internal server error.")
 * )
 */
Flight::route("GET /order", function(){
    Flight::json(Flight::order_service()->get_all());
});

// Get order by ID
/**
 * @OA\Get(
 *     path="/order/{id}",
 *     tags={"orders"},
 *     summary="Fetch order by ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer"), example=1),
 *     @OA\Response(response=200, description="Fetched order."),
 *     @OA\Response(response=400, description="Invalid ID.")
 * )
 */
Flight::route("GET /order/@id", function($id){
    Flight::json(Flight::order_service()->get_by_id($id));
});

// Get all orders for user
/**
 * @OA\Get(
 *     path="/order/user/{user_id}",
 *     tags={"orders"},
 *     summary="Fetch all orders by User ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="user_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Fetched orders by user ID."),
 *     @OA\Response(response=400, description="Invalid or missing user ID.")
 * )
 */
Flight::route("GET /order/user/@user_id", function($user_id){
    Flight::json(Flight::order_service()->get_by_user_id($user_id));
});

// Add a new order
/**
 * @OA\Post(
 *     path="/order",
 *     tags={"orders"},
 *     summary="Create a new order.",
 *     description="Add a new order to the database.",
 *     security={ {"ApiKey": {}} },
 *     @OA\RequestBody(
 *         required=true,
 *         description="Order data",
 *         @OA\JsonContent(
 *             required={"user_id", "total_amount", "status"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="total_amount", type="number", example=199.99),
 *             @OA\Property(property="status", type="string", example="pending"),
 *             @OA\Property(property="order_date", type="string", example="2025-11-09")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order created successfully."),
 *     @OA\Response(response=500, description="Internal server error.")
 * )
 */
Flight::route("POST /order", function(){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => "Order created successfully!",
        'data' => Flight::order_service()->add($data)
    ]);
});

// Update order
/**
 * @OA\Patch(
 *     path="/order/{id}",
 *     tags={"orders"},
 *     summary="Update an order.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="completed"),
 *             @OA\Property(property="total_amount", type="number", example=299.99)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order updated successfully."),
 *     @OA\Response(response=400, description="Invalid data.")
 * )
 */
Flight::route("PATCH /order/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => "Order updated successfully!",
        'data' => Flight::order_service()->update($data, $id, 'id')
    ]);
});

// Delete order
/**
 * @OA\Delete(
 *     path="/order/{id}",
 *     tags={"orders"},
 *     summary="Delete order by ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Order deleted successfully.")
 * )
 */
Flight::route("DELETE /order/@id", function($id){
    Flight::order_service()->delete($id);
    Flight::json(['message'=>"Order deleted successfully!"]);
});
?>