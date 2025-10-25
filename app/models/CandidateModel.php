<?php
// app/models/CandidateModel.php
namespace App\Models;
use App\Core\Database;
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class CandidateModel {
    protected $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM candidates ORDER BY position, name");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM candidates WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO candidates (name, position, course, manifesto, photo) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['position'], $data['course'], $data['manifesto'], $data['photo'] ?? null]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE candidates SET name=?, position=?, course=?, manifesto=?, photo=? WHERE id=?");
        return $stmt->execute([$data['name'], $data['position'], $data['course'], $data['manifesto'], $data['photo'] ?? null, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM candidates WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function tally() {
        $stmt = $this->db->query("SELECT c.id, c.name, c.position, COUNT(v.id) AS votes
            FROM candidates c
            LEFT JOIN votes v ON c.id = v.candidate_id
            GROUP BY c.id, c.name, c.position ORDER BY c.position, votes DESC");
        return $stmt->fetchAll();
    }
}
