<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/test",
 *     summary="Test endpoint",
 *     description="Checks if Swagger setup works properly.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     )
 * )
 */
Flight::route("GET /test", function() {
    Flight::json([
        "message" => "Test endpoint radi!"
    ]);
    