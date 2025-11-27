<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {

    public function verifyToken() {
        $authHeader = Flight::request()->getHeader("Authentication");

        if (!$authHeader) {
            Flight::halt(401, "Missing authentication header");
        }

        if (strpos($authHeader, 'Bearer ') !== 0) {
            Flight::halt(401, "Invalid token format. Must be: Bearer <token>");
        }

        $token = substr($authHeader, 7);

        try {
            $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
            Flight::set('user', $decoded->user);
            return TRUE;
        } catch (Exception $e) {
            Flight::halt(401, "Invalid or expired token");
        }
    }

    public function authorizeRole($requiredRole) {
        $user = Flight::get('user');
        if (!$user) {
            Flight::halt(401, "User missing in token");
        }

        if ($user->role !== $requiredRole) {
            Flight::halt(403, "Insufficient privileges");
        }
    }

    public function authorizeRoles($roles) {
        $user = Flight::get('user');
        if (!$user) {
            Flight::halt(401, "User missing in token");
        }

        if (!in_array($user->role, $roles)) {
            Flight::halt(403, "Forbidden: role not allowed");
        }
    }
}

