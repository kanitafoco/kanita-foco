<?php

/**
 * @OA\Get(
 *     path="/product",
 *     tags={"Product"},
 *     summary="Get all products",
 *     @OA\Response(response=200, description="List of products")
 * )
 */
Flight::route("GET /product", function() {
    Flight::json(Flight::product_service()->get_all());
});

/**
 * @OA\Get(
 *     path="/product/{id}",
 *     tags={"Product"},
 *     summary="Get product by ID",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Fetched product"),
 *     @OA\Response(response=404, description="Not found")
 * )
 */
Flight::route("GET /product/@id", function($id) {
    Flight::json(Flight::product_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/product",
 *     tags={"Product"},
 *     summary="Create product",
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *           required={"name", "price"},
 *           @OA\Property(property="name", type="string"),
 *           @OA\Property(property="description", type="string"),
 *           @OA\Property(property="price", type="number"),
 *           @OA\Property(property="category_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Product created")
 * )
 */
Flight::route("POST /product", function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::product_service()->add($data));
});

/**
 * @OA\Patch(
 *     path="/product/{id}",
 *     tags={"Product"},
 *     summary="Update product",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(@OA\JsonContent()),
 *     @OA\Response(response=200, description="Updated product")
 * )
 */
Flight::route("PATCH /product/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::product_service()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/product/{id}",
 *     tags={"Product"},
 *     summary="Delete product",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Deleted")
 * )
 */
Flight::route("DELETE /product/@id", function($id) {
    Flight::json(Flight::product_service()->delete($id));
});
