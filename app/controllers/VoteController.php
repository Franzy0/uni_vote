<?php
// app/controllers/VoteController.php
namespace App\Controllers;
use App\Models\CandidateModel;
use App\Models\VoteModel;
use App\Models\VoterModel;
use App\Core\Utils;
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VoteController {
    protected $candidateModel;
    protected $voteModel;
    protected $voterModel;
    public function __construct() {
        $this->candidateModel = new CandidateModel();
        $this->voteModel = new VoteModel();
        $this->voterModel = new VoterModel();
        Utils::startSession();
    }

    public function index() {
        if (!isset($_SESSION['voter'])) {
            header("Location: /");
            exit;
        }
        $voter = $_SESSION['voter'];
        if ($voter['has_voted']) {
            // redirect to results or a 'already voted' page
            $_SESSION['info'] = "You have already voted.";
            header("Location: /results");
            exit;
        }
        $candidates = $this->candidateModel->all();
        // group by position for view
        $byPosition = [];
        foreach ($candidates as $c) $byPosition[$c['position']][] = $c;
        $csrf = \App\Core\Utils::generateCSRF();
        include __DIR__ . '/../views/vote/voting.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /vote");
            exit;
        }
        if (!isset($_SESSION['voter'])) {
            header("Location: /");
            exit;
        }
        if (!\App\Core\Utils::validateCSRF($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = "Invalid CSRF token.";
            header("Location: /vote");
            exit;
        }
        $voter = $_SESSION['voter'];
        if ($voter['has_voted']) {
            $_SESSION['info'] = "You have already voted.";
            header("Location: /results");
            exit;
        }
        // expected: votes[position] = candidate_id
        $votes = $_POST['votes'] ?? [];
        foreach ($votes as $position => $candidate_id) {
            // basic validation: ensure candidate exists
            $candidate = $this->candidateModel->find($candidate_id);
            if ($candidate) {
                $this->voteModel->castVote($voter['id'], $candidate_id, $position);
            }
        }
        // mark voter as voted
        $this->voterModel->markVoted($voter['id']);
        // re-fetch and update session value
        $_SESSION['voter'] = $this->voterModel->findById($voter['id']);
        // optionally send confirmation email
        // load config for mail (similar to AuthController) or call a shared mail helper
        $_SESSION['success'] = "Your vote has been submitted. Thank you!";
        header("Location: /results");
    }

    public function results() {
        $tally = $this->candidateModel->tally();
        include __DIR__ . '/../views/vote/results.php';
    }
}
