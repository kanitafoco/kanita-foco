<?php
// Get all products
/**
 * @OA\Get(
 *     path="/products",
 *     tags={"products"},
 *     summary="Return all products from the API.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Response(response=200, description="List of products."),
 *     @OA\Response(response=500, description="Internal server error.")
 * )
 */
Flight::route("GET /products", function(){
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::product_service()->get_all());
});

// Get product by ID (query)
/**
 * @OA\Get(
 *     path="/product_by_id",
 *     tags={"products"},
 *     summary="Fetch product by ID (query).",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="query", required=true, description="Product ID", @OA\Schema(type="integer"), example=1),
 *     @OA\Response(response=200, description="Fetched product by ID."),
 *     @OA\Response(response=400, description="Invalid or missing ID.")
 * )
 */
Flight::route("GET /product_by_id", function(){
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::product_service()->get_by_id(Flight::request()->query['id']));
});

// Get product by path ID
/**
 * @OA\Get(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Fetch product by ID (path).",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, description="Product ID", @OA\Schema(type="integer"), example=1),
 *     @OA\Response(response=200, description="Fetched product by ID."),
 *     @OA\Response(response=400, description="Invalid or missing ID.")
 * )
 */
Flight::route("GET /product/@id", function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::product_service()->get_by_id($id));
});

// Get products by category ID
/**
 * @OA\Get(
 *     path="/products/{category_id}",
 *     tags={"products"},
 *     summary="Fetch all products by Category ID.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="category_id", in="path", required=true, description="Category ID", @OA\Schema(type="integer"), example=2),
 *     @OA\Response(response=200, description="Fetched products by Category ID."),
 *     @OA\Response(response=400, description="Invalid or missing ID.")
 * )
 */
Flight::route("GET /products/@category_id", function($category_id){
    Flight::json(Flight::product_service()->get_by_category_id($category_id));
});

// Add new product
/**
 * @OA\Post(
 *     path="/product",
 *     tags={"products"},
 *     summary="Add a new product.",
 *     description="Insert a new product into the database.",
 *     security={ {"ApiKey": {}} },
 *     @OA\RequestBody(
 *         required=true,
 *         description="Product data",
 *         @OA\JsonContent(
 *             required={"category_id", "name", "price", "description"},
 *             @OA\Property(property="category_id", type="integer", example=2, description="Product category ID"),
 *             @OA\Property(property="name", type="string", example="Laptop", description="Product name"),
 *             @OA\Property(property="price", type="number", format="float", example=999.99, description="Product price"),
 *             @OA\Property(property="description", type="string", example="High performance laptop", description="Product description"),
 *             @OA\Property(property="stock", type="integer", example=10, description="Available stock quantity")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Product added successfully."),
 *     @OA\Response(response=500, description="Internal server error.")
 * )
 */
Flight::route("POST /product", function(){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => "Product added successfully!",
        'data' => Flight::product_service()->add($data)
    ]);
});

// Update product
/**
 * @OA\Patch(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Update product details.",
 *     description="Modify existing product details.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, description="Product ID", @OA\Schema(type="integer"), example=1),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Updated product data",
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Gaming Laptop"),
 *             @OA\Property(property="price", type="number", format="float", example=1299.99),
 *             @OA\Property(property="description", type="string", example="Updated product description"),
 *             @OA\Property(property="stock", type="integer", example=8)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Product updated successfully."),
 *     @OA\Response(response=400, description="Invalid data."),
 *     @OA\Response(response=500, description="Server error.")
 * )
 */
Flight::route("PATCH /product/@id", function($id){
    $product = Flight::request()->data->getData();
    Flight::json([
        'message' => "Product updated successfully!",
        'data' => Flight::product_service()->update($id, $product)
    ]);
});

// Delete product
/**
 * @OA\Delete(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Delete a product.",
 *     security={ {"ApiKey": {}} },
 *     @OA\Parameter(name="id", in="path", required=true, description="Product ID", @OA\Schema(type="integer"), example=1),
 *     @OA\Response(response=200, description="Product deleted successfully."),
 *     @OA\Response(response=500, description="Internal server error.")
 * )
 */
Flight::route("DELETE /product/@id", function($id){
    Flight::product_service()->delete($id);
    Flight::json(['message' => "Product deleted successfully!"]);
});
