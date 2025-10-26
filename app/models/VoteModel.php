<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VoteModel extends Model
{
    protected $table = 'votes';
    protected $primary_key = 'id';
    protected $allowed_fields = ['voter_id', 'candidate_id', 'created_at'];

    public function recordVote($voter_id, $candidate_id)
    {
        $data = [
            'voter_id' => $voter_id,
            'candidate_id' => $candidate_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->table($this->table)->insert($data);
    }

    public function countVotes()
    {
        $sql = "
            SELECT 
                c.id, c.name, c.position, c.party, COUNT(v.id) AS total_votes
            FROM candidates c
            LEFT JOIN votes v ON c.id = v.candidate_id
            GROUP BY c.id, c.name, c.position, c.party
            ORDER BY c.position ASC
        ";
        return $this->db->raw($sql)->result_array();
    }

    public function totalVotes()
    {
        return $this->db->table($this->table)->count_all();
    }
}
