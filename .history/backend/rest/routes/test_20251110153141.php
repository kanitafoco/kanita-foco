<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/test",
 *     summary="Test endpoint",
 *     description="This is just a test endpoint to verify Swagger works.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful test"
 *     )
 * )
 */
