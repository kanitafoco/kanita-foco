<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/test",
 *     summary="Test endpoint",
 *     description="Checks if Swagger is working properly.",
 *     @OA\Response(response=200, description="Successful test")
 * )
 */
