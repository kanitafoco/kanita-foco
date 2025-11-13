<?php
/**
 * @OA\Info(
 *     title="Shoes Shop API",
 *     version="1.0.0",
 *     description="REST API za Shoes Shop backend",
 *     @OA\Contact(
 *         email="shoesshop.support@gmail.com",
 *         name="Shoes Shop Dev Team"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url="http://localhost/ShoesShop/backend",
 *     description="Lokalni razvojni server (Mac)"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="ApiKeyAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Koristi Bearer token (npr. 'Bearer xyz123')"
 * )
 */
