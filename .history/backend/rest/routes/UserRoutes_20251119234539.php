<?php
// Get all users
/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Return all users from the API.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="List of users."
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error."
 *     )
 * )
 */
Flight::route("GET /users", function(){
    Flight::json(Flight::user_service()->get_all());
});

// Get user by ID (query)
/**
 * @OA\Get(
 *     path="/user_by_id",
 *     tags={"users"},
 *     summary="Fetch individual user by ID (query).",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=true,
 *         description="User ID.",
 *         @OA\Schema(type="integer"),
 *         example=1
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Fetched user by ID."
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Missing or invalid ID."
 *     )
 * )
 */
Flight::route("GET /user_by_id", function(){
    Flight::json(Flight::user_service()->get_by_id(Flight::request()->query['id']));
});

// Get user by path ID
/**
 * @OA\Get(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Fetch individual user by ID (path).",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID.",
 *         @OA\Schema(type="integer"),
 *         example=1
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Fetched individual user by ID."
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid or missing ID."
 *     )
 * )
 */
Flight::route("GET /user/@id", function($id){
    Flight::json(Flight::user_service()->get_by_id($id));
});

// Get user by email (custom route)
/**
 * @OA\Get(
 *     path="/user/email/{email}",
 *     tags={"users"},
 *     summary="Fetch user by email.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="Email address of the user.",
 *         @OA\Schema(type="string"),
 *         example="john@example.com"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Fetched user by email."
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid or missing email."
 *     )
 * )
 */
Flight::route("GET /user/email/@email", function($email){
    Flight::json(Flight::user_service()->get_by_email($email));
});

// Add a new user
/**
 * @OA\Post(
 *     path="/user",
 *     summary="Add a new user.",
 *     description="Add a new user to the system.",
 *     tags={"users"},
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\RequestBody(
 *         description="Add new user data",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"full_name", "email", "password_hash", "role"},
 *                 @OA\Property(property="full_name", type="string", example="John Doe", description="User full name"),
 *                 @OA\Property(property="email", type="string", example="john@example.com", description="User email address"),
 *                 @OA\Property(property="password_hash", type="string", example="hashed_password", description="Password hash"),
 *                 @OA\Property(property="role", type="string", example="admin", description="User role")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User has been added successfully."
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error."
 *     )
 * )
 */
Flight::route("POST /user", function(){
    $request = Flight::request()->data->getData();
    if (isset($request['role'])) {
        $request['role'] = substr($request['role'], 0, 5);
    ]);
});

// Update user details
/**
 * @OA\Patch(
 *     path="/user/{id}",
 *     summary="Edit user details.",
 *     description="Update user information using their ID.",
 *     tags={"users"},
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID.",
 *         @OA\Schema(type="integer"),
 *         example=1
 *     ),
 *     @OA\RequestBody(
 *         description="Updated user data",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="full_name", type="string", example="Jane Doe"),
 *             @OA\Property(property="email", type="string", example="jane@example.com"),
 *             @OA\Property(property="role", type="string", example="customer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User has been updated successfully."
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input data."
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error."
 *     )
 * )
 */
Flight::route("PATCH /user/@id", function($id){
    $user = Flight::request()->data->getData();
    Flight::json([
        'message' => "User has been updated!",
        'data' => Flight::user_service()->update($id, $user)
    ]);
});

// Delete a user
/**
 * @OA\Delete(
 *     path="/user/{id}",
 *     summary="Delete a user by ID.",
 *     description="Remove a user from the database using their ID.",
 *     tags={"users"},
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID.",
 *         @OA\Schema(type="integer"),
 *         example=1
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully."
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error."
 *     )
 * )
 */
Flight::route("DELETE /user/@id", function($id){
    $result = Flight::user_service()->delete($id);   // <-- NEDOSTAJAO TI JE OVAJ RED

    if ($result["error"]) {
        Flight::json($result, 400);
        return;
    }

    Flight::json(['message' => $result["message"]]);
});
