<?php

class AuthUtil
{
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login($username, $password, $pdo) {
        self::init();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'] ?? 'user'
            ];
            return true;
        }

        return false;
    }

    public static function user() {
        self::init();
        return $_SESSION['user'] ?? null;
    }

    public static function check() {
        self::init();
        return isset($_SESSION['user']);
    }

    public static function logout() {
        self::init();

        unset($_SESSION['user']);
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }
}
