<?php

/**
 * @OA\Get(
 *     path="/review/{id}",
 *     tags={"Review"},
 *     summary="Get review by ID",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Fetched review")
 * )
 */
Flight::route('GET /review/@id', function($id) {
    Flight::json(Flight::review_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/review",
 *     tags={"Review"},
 *     summary="Add review",
 *     @OA\Response(response=200, description="Review added")
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
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="Review deleted")
 * )
 */
Flight::route('DELETE /review/@id', function($id) {
    Flight::json(Flight::review_service()->delete($id));
});
