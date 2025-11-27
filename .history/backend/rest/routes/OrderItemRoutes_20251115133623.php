/**
 * @OA\Post(
 *     path="/order-item",
 *     tags={"OrderItem"},
 *     summary="Add product to order",
 *     @OA\Response(response=200, description="Order item added")
 * )
 */
Flight::route('POST /order-item', function() {
    Flight::json(Flight::order_item_service()->add(Flight::request()->data->getData()));
});
