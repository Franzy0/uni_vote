<?php
// app/models/VoterModel.php
namespace App\Models;
use App\Core\Database;
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VoterModel {
    protected $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function create($student_id, $fullname, $email, $password_hash) {
        $stmt = $this->db->prepare("INSERT INTO voters (student_id, fullname, email, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$student_id, $fullname, $email, $password_hash]);
    }

    public function findByStudentId($student_id) {
        $stmt = $this->db->prepare("SELECT * FROM voters WHERE student_id = ?");
        $stmt->execute([$student_id]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM voters WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function markVoted($id) {
        $stmt = $this->db->prepare("UPDATE voters SET has_voted = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function authenticate($student_id, $password) {
        $v = $this->findByStudentId($student_id);
        if ($v && password_verify($password, $v['password'])) return $v;
        return false;
    }
}
