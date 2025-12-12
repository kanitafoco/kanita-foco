<?php
/**
 * @OA\Info(
 *     title="Shoes Shop API",
 *     description="REST API for Shoes Shop Project",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="kanita.foco@stu.ibu.edu.ba",
 *         name="Kanita Fočo"
 *     )
 * )
 */

/**
 * SERVER URL — AUTOMATSKI ZA LOKALNI PROJEKAT
 *
 * Ovdje NE ide port!
 * Ovdje ide tačan path foldera na localhostu.
 *
 * Ako ti je projekt ovdje:
 * http://localhost/kanita-foco/backend
 * onda to ide u URL:
 */

 /**
 * @OA\Server(
 *     url="http://localhost/kanita-foco/backend",
 *     description="Local API server"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */
?>
