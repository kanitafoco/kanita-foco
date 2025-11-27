<?php

/**
 * @OA\Get(
 *     path="/category",
 *     tags={"Category"},
 *     summary="Get all categories",
 *     @OA\Response(response=200, description="List of categories")
 * )
 */
Flight::route('GET /category', function() {
    $data = Flight::category_service()->get_all();
    Flight::json($data);
});

/**
 * @OA\Get(
 *     path="/category/{id}",
 *     tags={"Category"},
 *     summary="Get category by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Fetched category"),
 *     @OA\Response(response=404, description="Category not found")
 * )
 */
Flight::route('GET /category/@id', function($id) {
    $data = Flight::category_service()->get_by_id($id);
    Flight::json($data);
});
