<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
Flight::group('/auth', function() {
   /**
    * @OA\Post(
    *     path="/auth/register",
    *     summary="Register new user.",
    *     description="Add a new user to the database.",
    *     tags={"auth"},
    *     security={
    *         {"ApiKey": {}}
    *     },
    *     @OA\RequestBody(
    *         description="Add new user",
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 required={"password", "email",  "full_name"},
    *                 @OA\Property(
    *                     property="full_name",
    *                     type="string",
    *                     example="Test User",
    *                     description="User name"
    *                 ),@OA\Property(
    *                     property="password",
    *                     type="string",
    *                     example="12345",
    *                     description="User password"
    *                 ),
    *                 @OA\Property(
    *                     property="email",
    *                     type="string",
    *                     example="test@test.com",
    *                     description="User email"
    *                 )
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="User has been added."
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal server error."
    *     )
    * )
    */
   Flight::route("POST /register", function () {
    $data = Flight::request()->data->getData();

    if (Flight::auth_service()->get_user_by_email($data['email'])) {
        Flight::json([
            "success" => false,
            "message" => "Email already registered."
        ], 409);
        return;
    }

    $response = Flight::auth_service()->register($data);

    Flight::json([
        'success' => true,
        'message' => 'User registered successfully',
        'data' => $response['data']
    ], 200);
        
    });
    /**
     * @OA\Post(
     *      path="/auth/login",
     *      tags={"auth"},
     *      summary="Login to system using email and password",
     *      @OA\Response(
     *           response=200,
     *           description="Student data and JWT"
     *      ),
     *      @OA\RequestBody(
     *          description="Credentials",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", example="test@test.com", description="Student email address"),
     *              @OA\Property(property="password", type="string", example="12345", description="Student password")
     *          )
     *      )
     * )
     */
    Flight::route('POST /login', function() {
        $data = Flight::request()->data->getData();
 
 
        $response = Flight::auth_service()->login($data);
   
        if ($response['success']) {
            Flight::json([
                'message' => 'User logged in successfully',
                'data' => $response['data']
            ]);
        } else {
            Flight::halt(500, $response['error']);
        }
    });
 });
 ?>
 