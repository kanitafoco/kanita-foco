<?php

/**
 * @OA\Get(
 *     path="/review",
 *     tags={"Review"},
 *     summary="Get all reviews",
 *     @OA\Response(response=200, description="List of reviews")
 * )
 */
Flight::route("GET /review", function(){
    Flight::json(Flight::review_service()->get_all());
});

/**
 * @OA\Post(
 *     path="/review",
 *     tags={"Review"},
 *     summary="Create review",
 *     @OA\RequestBody(@OA\JsonContent(
 *        required={"user_id", "product_id", "rating"},
 *        @OA\Property(property="user_id", type="integer"),
 *        @OA\Property(property="product_id", type="integer"),
 *        @OA\Property(property="rating", type="number"),
 *        @OA\Property(property="comment", type="string")
 *     )),
 *     @OA\Response(response=200, description="Review added")
 * )
 */
Flight::route("POST /review", function(){
    Flight::json(Flight::review_service()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Delete(
 *     path="/review/{id}",
 *     tags={"Review"},
 *     summary="Delete review",
 *     @OA\Parameter(name="id", in="path"),
 *     @OA\Response(response=200, description="Deleted")
 * )
 */
Flight::route("DELETE /review/@id", function($id){
    Flight::json(Flight::review_service()->delete($id));
});
