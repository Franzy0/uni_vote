<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('CandidateModel');
        $this->call->model('VoteModel');
        $this->call->model('VoterModel');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['voter_id'])) {
            redirect('/auth/login');
        }
    }

    // Voting page
    public function index()
    {
        $candidates = $this->CandidateModel->get_all();
        $voter_id = $_SESSION['voter_id'];

        if ($this->VoterModel->has_voted($voter_id)) {
            $this->call->view('vote/confirmation', ['message' => 'You have already voted.']);
            return;
        }

        $this->call->view('vote/voting', ['candidates' => $candidates]);
    }

    // Submit votes
    public function submit()
    {
        $voter_id = $_SESSION['voter_id'];

        if ($this->VoterModel->has_voted($voter_id)) {
            redirect('/vote');
        }

        if (!empty($_POST['votes'])) {
            foreach ($_POST['votes'] as $candidate_id) {
                $this->VoteModel->submit_vote([
                    'voter_id' => $voter_id,
                    'candidate_id' => $candidate_id
                ]);
            }

            $this->VoterModel->mark_as_voted($voter_id);
            redirect('/vote/success');
        } else {
            redirect('/vote');
        }
    }

    // Success page
    public function success()
    {
        $this->call->view('vote/confirmation', ['message' => 'Your vote has been successfully submitted.']);
    }
}
