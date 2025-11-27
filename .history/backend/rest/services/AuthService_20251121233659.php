<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthService extends BaseService {
   private $auth_dao;
   public function __construct() {
       $this->auth_dao = new AuthDao();
       parent::__construct(new AuthDao);
   }


   public function get_user_by_email($email){
       return $this->auth_dao->get_user_by_email($email);
   }


   public function register($entity) {  
    if (empty($entity['email']) || empty($entity['password']) || empty($entity['full_name'])) {
        return ['success' => false, 'error' => 'full_name, email and password are required.'];
    }

    // check if email exists
    if ($this->auth_dao->get_user_by_email($entity['email'])) {
        return ['success' => false, 'error' => 'Email already registered.'];
    }

    // prepare password hash
    $entity['password_hash'] = password_hash($entity['password'], PASSWORD_BCRYPT);
    unset($entity['password']);

    // default role
    if (!isset($entity['role'])) {
        $entity['role'] = 'customer';
    }

    // insert into DB
    $new_user_id = parent::add($entity);

    return [
        'success' => true,
        'data' => ['user_id' => $new_user_id]
    ];
}


public function login($entity) {  
    if (empty($entity['email']) || empty($entity['password'])) {
        return ['success' => false, 'error' => 'Email and password are required.'];
    }

    $user = $this->auth_dao->get_user_by_email($entity['email']);

    if(!$user || !password_verify($entity['password'], $user['password_hash'])) {
        return ['success' => false, 'error' => 'Invalid username or password.'];
    }

    unset($user['password_hash']); // hide hash

    $jwt_payload = [
        'user' => $user,
        'iat' => time(),
        'exp' => time() + (60 * 60 * 24)
    ];

    $token = JWT::encode($jwt_payload, Config::JWT_SECRET(), 'HS256');

    return [
        'success' => true,
        'data' => array_merge($user, ['token' => $token])
    ];
}
}\