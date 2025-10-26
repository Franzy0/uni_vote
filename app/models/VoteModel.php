<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VoteModel extends Model
{
    protected $table = 'votes';

    public function hasVoted($voter_id)
    {
        $row = $this->db->table($this->table)->where('voter_id', $voter_id)->get()->row_array();
        return !empty($row);
    }

    public function castVote($voter_id, $candidate_id, $position)
    {
        // Ensure voter hasn't voted already
        if ($this->hasVoted($voter_id)) return false;
        return $this->db->table($this->table)->insert([
            'voter_id' => $voter_id,
            'candidate_id' => $candidate_id,
            'position' => $position
        ]);
    }

    public function votesByVoter($voter_id)
    {
        return $this->db->table($this->table)->where('voter_id', $voter_id)->get()->result_array();
    }
}
