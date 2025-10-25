<?php
// app/models/AdminModel.php
namespace App\Models;
use App\Core\Database;
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AdminModel {
    protected $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $a = $stmt->fetch();
        if ($a && password_verify($password, $a['password'])) return $a;
        return false;
    }
}
