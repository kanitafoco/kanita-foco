<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/test",
 *     summary="Test endpoint",
 *     description="Check if Swagger documentation works properly.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     )
 * )
 */
