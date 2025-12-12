<?php
// Get all categories
/**
 * @OA\Get(
 *     path="/categories",
 *     tags={"categories"},
 *     summary="Return all categories.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Response(response=200, description="List of categories."),
 *     @OA\Response(response=500, description="Internal server error.")
 * )
 */
Flight::route("GET /categories", function(){
    Flight::json(Flight::category_service()->get_all());
});

// Get category by ID
/**
 * @OA\Get(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Fetch category by ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, description="Category ID", @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Fetched category."),
 *     @OA\Response(response=400, description="Invalid ID.")
 * )
 */
Flight::route("GET /category/@id", function($id){
    Flight::json(Flight::category_service()->get_by_id($id));
});

// Add category
/**
 * @OA\Post(
 *     path="/category",
 *     tags={"categories"},
 *     summary="Add a new category.",
 *     security={ {"ApiKey": {}} },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Electronics"),
 *             @OA\Property(property="description", type="string", example="All electronic items")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Category added successfully."),
 *     @OA\Response(response=500, description="Internal server error.")
 * )
 */
Flight::route("POST /category", function(){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => "Category added successfully!",
        'data' => Flight::category_service()->add($data)
    ]);
});

// Update category
/**
 * @OA\Patch(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Update category.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *             @OA\Property(property="description", type="string", example="Updated description")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Category updated successfully."),
 *     @OA\Response(response=500, description="Server error.")
 * )
 */
Flight::route("PATCH /category/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => "Category updated successfully!",
        'data' => Flight::category_service()->update($data, $id, 'id')
    ]);
});

// Delete category
/**
 * @OA\Delete(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Delete category by ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Category deleted successfully.")
 * )
 */
Flight::route("DELETE /category/@id", function($id){
    Flight::category_service()->delete($id);
    Flight::json(['message'=>"Category deleted successfully."]);
});
