<?php

/**
 * @OA\Get(
 *     path="/category",
 *     tags={"Category"},
 *     summary="Return all categories",
 *     @OA\Response(response=200, description="List of categories")
 * )
 */
Flight::route('GET /category', function() {
    Flight::json(Flight::category_service()->get_all());
});

/**
 * @OA\Get(
 *     path="/category/{id}",
 *     tags={"Category"},
 *     summary="Get category by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Category found"),
 *     @OA\Response(response=404, description="Category not found")
 * )
 */
Flight::route('GET /category/@id', function($id) {
    Flight::json(Flight::category_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/category",
 *     tags={"Category"},
 *     summary="Create a new category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Category created")
 * )
 */
Flight::route('POST /category', function() {
    Flight::json(Flight::category_service()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Patch(
 *     path="/category/{id}",
 *     tags={"Category"},
 *     summary="Update category",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Category updated")
 * )
 */
Flight::route('PATCH /category/@id', function($id) {
    Flight::json(Flight::category_service()->update($id, Flight::request()->data->getData()));
});

/**
 * @OA\Delete(
 *     path="/category/{id}",
 *     tags={"Category"},
 *     summary="Delete category",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Category deleted")
 * )
 */
Flight::route('DELETE /category/@id', function($id) {
    Flight::json(Flight::category_service()->delete($id));
});
