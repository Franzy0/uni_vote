<?php
// app/core/Database.php
namespace App\Core;
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Database {
    private static $pdo = null;
    public static function getConnection() {
        if (self::$pdo) return self::$pdo;
        $cfg = require __DIR__ . '/../config/config.php';
        $db = $cfg['db'];
        $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";
        try {
            self::$pdo = new \PDO($dsn, $db['user'], $db['pass'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);
            return self::$pdo;
        } catch (\PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }
}
