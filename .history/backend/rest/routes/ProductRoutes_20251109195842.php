<?php
/**
 * @OA\Get(
 *     path="/products",
 *     tags={"products"},
 *     summary="Get all products",
 *     @OA\Response(response=200, description="List of products")
 * )
 */
Flight::route("GET /products", function(){
    Flight::json(Flight::product_service()->get_all());
});

/**
 * @OA\Get(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Get product by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Single product")
 * )
 */
Flight::route("GET /product/@id", function($id){
    Flight::json(Flight::product_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/product",
 *     tags={"products"},
 *     summary="Add new product",
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="price", type="number", format="float"),
 *         @OA\Property(property="category_id", type="integer")
 *     )),
 *     @OA\Response(response=200, description="Product added")
 * )
 */
Flight::route("POST /product", function(){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => "Product added!", 'data' => Flight::product_service()->add($data)]);
});

/**
 * @OA\Patch(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Update product",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="price", type="number", format="float"),
 *         @OA\Property(property="category_id", type="integer")
 *     )),
 *     @OA\Response(response=200, description="Product updated")
 * )
 */
Flight::route("PATCH /product/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => "Product updated!", 'data' => Flight::product_service()->update($data, $id, 'product_id')]);
});

/**
 * @OA\Delete(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Delete product",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Product deleted")
 * )
 */
Flight::route("DELETE /product/@id", function($id){
    Flight::product_service()->delete($id);
    Flight::json(['message' => "Product deleted!"]);
});
