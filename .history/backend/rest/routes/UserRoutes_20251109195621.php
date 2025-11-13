<?php
/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     @OA\Response(response=200, description="List of users")
 * )
 */
Flight::route("GET /users", function(){
    Flight::json(Flight::user_service()->get_all());
});

/**
 * @OA\Get(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Single user")
 * )
 */
Flight::route("GET /user/@id", function($id){
    Flight::json(Flight::user_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/user",
 *     tags={"users"},
 *     summary="Add new user",
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="full_name", type="string"),
 *         @OA\Property(property="email", type="string"),
 *         @OA\Property(property="password_hash", type="string"),
 *         @OA\Property(property="role", type="string")
 *     )),
 *     @OA\Response(response=200, description="User added")
 * )
 */
Flight::route("POST /user", function(){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => "User added!", 'data' => Flight::user_service()->add($data)]);
});

/**
 * @OA\Patch(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Update user",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="full_name", type="string"),
 *         @OA\Property(property="email", type="string"),
 *         @OA\Property(property="role", type="string")
 *     )),
 *     @OA\Response(response=200, description="User updated")
 * )
 */
Flight::route("PATCH /user/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => "User updated!", 'data' => Flight::user_service()->update($data, $id, 'user_id')]);
});

/**
 * @OA\Delete(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Delete user",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="User deleted")
 * )
 */
Flight::route("DELETE /user/@id", function($id){
    Flight::user_service()->delete($id);
    Flight::json(['message' => "User deleted!"]);
});
