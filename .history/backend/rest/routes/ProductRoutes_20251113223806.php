<?php

/**
 * @OA\Get(
 *     path="/product",
 *     tags={"Product"},
 *     summary="Get all products",
 *     @OA\Response(response=200, description="List of products")
 * )
 */
Flight::route('GET /product', function() {
    Flight::json(Flight::product_service()->get_all());
});

/**
 * @OA\Get(
 *     path="/product/{id}",
 *     tags={"Product"},
 *     summary="Get a product by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Product details")
 * )
 */
Flight::route('GET /product/@id', function($id) {
    Flight::json(Flight::product_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/product",
 *     tags={"Product"},
 *     summary="Create new product",
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             required={"name","price","category_id"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="price", type="number"),
 *             @OA\Property(property="category_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Product created")
 * )
 */
Flight::route('POST /product', function() {
    Flight::json(Flight::product_service()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Patch(
 *     path="/product/{id}",
 *     tags={"Product"},
 *     summary="Update a product",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="price", type="number"),
 *             @OA\Property(property="category_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Product updated")
 * )
 */
Flight::route('PATCH /product/@id', function($id) {
    Flight::json(Flight::product_service()->update($id, Flight::request()->data->getData()));
});

/**
 * @OA\Delete(
 *     path="/product/{id}",
 *     tags={"Product"},
 *     summary="Delete a product",
 *     @OA\Response(response=200, description="Product deleted")
 * )
 */
Flight::route('DELETE /product/@id', function($id) {
    Flight::json(Flight::product_service()->delete($id));
});
