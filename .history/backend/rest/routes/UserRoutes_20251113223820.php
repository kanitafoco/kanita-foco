<?php

/**
 * @OA\Get(
 *     path="/user",
 *     tags={"User"},
 *     summary="Get all users",
 *     @OA\Response(response=200, description="List of users")
 * )
 */
Flight::route('GET /user', function() {
    Flight::json(Flight::user_service()->get_all());
});

/**
 * @OA\Get(
 *     path="/user/{id}",
 *     tags={"User"},
 *     summary="Get user by ID",
 *     @OA\Parameter(name="id", in="path", required=true),
 *     @OA\Response(response=200, description="User details")
 * )
 */
Flight::route('GET /user/@id', function($id) {
    Flight::json(Flight::user_service()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/user",
 *     tags={"User"},
 *     summary="Create new user",
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             required={"email","password","full_name"},
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="full_name", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="User created")
 * )
 */
Flight::route('POST /user', function() {
    Flight::json(Flight::user_service()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Patch(
 *     path="/user/{id}",
 *     tags={"User"},
 *     summary="Update user",
 *     @OA\Parameter(name="id", in="path", required=true)
 * )
 */
Flight::route('PATCH /user/@id', function($id) {
    Flight::json(Flight::user_service()->update($id, Flight::request()->data->getData()));
});

/**
 * @OA\Delete(
 *     path="/user/{id}",
 *     tags={"User"},
 *     summary="Delete user"
 * )
 */
Flight::route('DELETE /user/@id', function($id) {
    Flight::json(Flight::user_service()->delete($id));
});
