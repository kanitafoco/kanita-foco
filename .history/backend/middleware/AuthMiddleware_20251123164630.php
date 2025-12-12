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
    
        $token = substr($authHeader, 7); // ukloni "Bearer "
    
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
    
}

