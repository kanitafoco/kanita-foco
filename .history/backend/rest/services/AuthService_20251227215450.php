<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
require_once __DIR__ . '/../Config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {

    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct($this->auth_dao);
    }

    public function get_user_by_email($email) {
        return $this->auth_dao->get_user_by_email($email);
    }

    public function register($entity) {

        if (empty($entity['email']) || empty($entity['password'])) {
            return [
                'success' => false,
                'error' => 'Email and password are required.'
            ];
        }

        if (empty($entity['full_name'])) {
            $entity['full_name'] = 'New User';
        }

        $entity['password_hash'] = password_hash($entity['password'], PASSWORD_BCRYPT);
        unset($entity['password']);

        if (empty($entity['role'])) {
            $entity['role'] = 'customer';
        }

        $user_id = parent::add($entity);

        return [
            'success' => true,
            'data' => [
                'user_id' => $user_id
            ]
        ];
    }

    public function login($entity) {

        if (empty($entity['email']) || empty($entity['password'])) {
            return [
                'success' => false,
                'error' => 'Email and password are required.'
            ];
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);

        if (!$user || !password_verify($entity['password'], $user['password_hash'])) {
            return [
                'success' => false,
                'error' => 'Invalid email or password.'
            ];
        }

        unset($user['password_hash']);

        $payload = [
            'user' => $user,
            'iat'  => time(),
            'exp'  => time() + (60 * 60 * 24)
        ];

        $token = JWT::encode($payload, Config::JWT_SECRET(), 'HS256');

        return [
            'success' => true,
            'data' => array_merge($user, [
                'token' => $token
            ])
        ];
    }
}
