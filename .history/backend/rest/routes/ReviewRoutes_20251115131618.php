<?php
// Get all reviews
/**
 * @OA\Get(
 *     path="/review",
 *     tags={"reviews"},
 *     summary="Return all reviews.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Response(response=200, description="List of reviews.")
 * )
 */
Flight::route("GET /review", function(){
    Flight::json(Flight::review_service()->get_all());
});

// Get review by ID
/**
 * @OA\Get(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     summary="Fetch review by ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Fetched review.")
 * )
 */
Flight::route("GET /review/@id", function($id){
    Flight::json(Flight::review_service()->get_by_id($id));
});

// Get all reviews for product
/**
 * @OA\Get(
 *     path="/review/product/{product_id}",
 *     tags={"reviews"},
 *     summary="Fetch reviews by product ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Fetched reviews for product.")
 * )
 */
Flight::route("GET /review/product/@product_id", function($product_id){
    Flight::json(Flight::review_service()->get_by_product_id($product_id));
});

// Add new review
/**
 * @OA\Post(
 *     path="/review",
 *     tags={"reviews"},
 *     summary="Add a new review.",
 *     description="Add user review for product.",
 *     security={ {"ApiKey": {}} },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_id", "user_id", "rating", "comment"},
 *             @OA\Property(property="product_id", type="integer", example=4),
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="rating", type="integer", example=5),
 *             @OA\Property(property="comment", type="string", example="Excellent product!")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Review added successfully.")
 * )
 */
Flight::route("POST /review", function(){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message'=>"Review added successfully!",
        'data'=>Flight::review_service()->add($data)
    ]);
});

// Update review
/**
 * @OA\Patch(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     summary="Update a review.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="rating", type="integer", example=4),
 *             @OA\Property(property="comment", type="string", example="Updated comment text.")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Review updated successfully.")
 * )
 */
Flight::route("PATCH /review/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message'=>"Review updated successfully!",
        'data'=>Flight::review_service()->update($data, $id, 'id')
    ]);
});

// Delete review
/**
 * @OA\Delete(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     summary="Delete a review by ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Review deleted successfully.")
 * )
 */
Flight::route("DELETE /review/@id", function($id){
    Flight::review_service()->delete($id);
    Flight::json(['message'=>"Review deleted successfully!"]);
});
?>