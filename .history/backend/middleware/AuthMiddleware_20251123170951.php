<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {

    public function verifyToken() {

        $authHeader = Flight::request()->getHeader("Authentication");

        if (!$authHeader) {
            Flight::halt(401, "Missing authentication header");
        }

        if (strpos($authHeader, "Bearer ") !== 0) {
            Flight::halt(401, "Invalid token format. Must be: Bearer <token>");
        }

        $token = substr($authHeader, 7);

        try {
            $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));

            if (!isset($decoded->user)) {
                Flight::halt(401, "User missing in token");
            }

            Flight::set('user', $decoded->user);
            Flight::set('jwt_token', $token);

            return TRUE;

        } catch (Exception $e) {
            Flight::halt(401, "Invalid or expired token");
        }
    }

    public function authorizeRole($requiredRole) {
        $user = Flight::get('user');

        if (!$user) {
            Flight::halt(401, "User not authenticated");
        }

        if ($user->role !== $requiredRole) {
            Flight::halt(403, "Access denied: insufficient privileges");
        }
    }

    public function authorizeRoles($roles) {
        $user = Flight::get('user');

        if (!$user) {
            Flight::halt(401, "User not authenticated");
        }

        if (!in_array($user->role, $roles)) {
            Flight::halt(403, "Forbidden: role not allowed");
        }
    }
}

