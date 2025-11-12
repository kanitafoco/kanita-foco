<?php
/**
 * @OA\Get(
 *      path="/users",
 *      tags={"users"},
 *      summary="Return all users from the API.",
 *      @OA\Response(
 *          response=200,
 *          description="List of users."
 *      )
 * )
 */
Flight::route("GET /users", function(){
    Flight::json(Flight::user_service()->get_all());
});

/**
 * @OA\Get(
 *      path="/user_by_id",
 *      tags={"users"},
 *      summary="Fetch user by query ID.",
 *      @OA\Parameter(
 *          name="id",
 *          in="query",
 *          required=true,
 *          description="User ID",
 *          @OA\Schema(type="integer"),
 *          example=1
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="User fetched successfully."
 *      )
 * )
 */
Flight::route("GET /user_by_id", function(){
    Flight::json(Flight::user_service()->get_by_id(Flight::request()->query['id']));
});

/**
 * @OA\Get(
 *      path="/user/{id}",
 *      tags={"users"},
 *      summary="Fetch user by path ID.",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="User ID",
 *          @OA\Schema(type="integer"),
 *          example=1
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="User fetched successfully."
 *      )
 * )
 */
Flight::route("GET /user/@id", function($id){
    Flight::json(Flight::user_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/user",
 *     tags={"users"},
 *     summary="Add new user.",
 *     @OA\RequestBody(
 *         description="User data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"full_name", "email", "password_hash", "role"},
 *             @OA\Property(property="full_name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@gmail.com"),
 *             @OA\Property(property="password_hash", type="string", example="hashedpassword123"),
 *             @OA\Property(property="role", type="string", example="customer")
 *         )
 *     ),
 *     @OA\Response(response=200, description="User added successfully."),
 *     @OA\Response(response=500, description="Internal server error.")
 * )
 */
Flight::route("POST /user", function(){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => "User added successfully!",
        'data' => Flight::user_service()->add($data)
    ]);
});

/**
 * @OA\Patch(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Update user by ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer"),
 *         example=1
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="full_name", type="string", example="Jane Doe"),
 *             @OA\Property(property="email", type="string", example="jane@gmail.com"),
 *             @OA\Property(property="role", type="string", example="admin")
 *         )
 *     ),
 *     @OA\Response(response=200, description="User updated successfully.")
 * )
 */
Flight::route("PATCH /user/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => "User updated successfully!",
        'data' => Flight::user_service()->update($data, $id, 'user_id')
    ]);
});

/**
 * @OA\Delete(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Delete user by ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         example=1
 *     ),
 *     @OA\Response(response=200, description="User deleted successfully.")
 * )
 */
Flight::route("DELETE /user/@id", function($id){
    Flight::user_service()->delete($id);
    Flight::json(['message' => "User deleted successfully!"]);
});
