<?php
// app/models/VoteModel.php
namespace App\Models;
use App\Core\Database;
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VoteModel {
    protected $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function castVote($voter_id, $candidate_id, $position) {
        $stmt = $this->db->prepare("INSERT INTO votes (voter_id, candidate_id, position) VALUES (?, ?, ?)");
        return $stmt->execute([$voter_id, $candidate_id, $position]);
    }

    public function votesByVoter($voter_id) {
        $stmt = $this->db->prepare("SELECT * FROM votes WHERE voter_id = ?");
        $stmt->execute([$voter_id]);
        return $stmt->fetchAll();
    }
}
