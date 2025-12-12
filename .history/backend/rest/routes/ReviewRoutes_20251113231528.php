<?php

/**
 * @OA\Get(
 *     path="/review/{id}",
 *     tags={"Review"},
 *     summary="Get review by ID",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Review details"),
 *     @OA\Response(response=404, description="Review not found")
 * )
 */
Flight::route('GET /review/@id', function($id) {
    Flight::json(Flight::review_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/review",
 *     tags={"Review"},
 *     summary="Create review",
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             required={"product_id","user_id","rating"},
 *             @OA\Property(property="product_id", type="integer"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="rating", type="integer"),
 *             @OA\Property(property="comment", type="string")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Review created")
 * )
 */
Flight::route('POST /review', function() {
    Flight::json(Flight::review_service()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Delete(
 *     path="/review/{id}",
 *     tags={"Review"},
 *     summary="Delete review",
 *     @OA\Response(response=200, description="Review deleted")
 * )
 */
Flight::route('DELETE /review/@id', function($id) {
    Flight::json(Flight::review_service()->delete($id));
});
