<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Shoes Shop API",
 *     description="API documentation for the Shoes Shop project",
 *     version="1.0",
 *     @OA\Contact(
 *         email="kanita.foco@stu.ibu.edu.ba",
 *         name="Shoes Shop"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=BASE_URL,
 *     description="Local API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="ApiKeyAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */
