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
        Utils::startSession();
    }

    // Show voting page (grouped by position)
    public function index()
    {
        if (empty($_SESSION['voter'])) {
            redirect('/auth/login');
        }

        $voter = $_SESSION['voter'];
        if ($voter['has_voted']) {
            Utils::flash('info', 'You have already voted.');
            redirect('/vote/success');
        }

        $candidates = $this->CandidateModel->all();
        // group by position
        $byPosition = [];
        foreach ($candidates as $c) $byPosition[$c['position']][] = $c;

        $csrf = Utils::generateCSRF();
        $this->call->view('vote/voting', ['byPosition' => $byPosition, 'csrf' => $csrf]);
    }

    // POST submit votes (expects votes[position] = candidate_id)
    public function vote()
    {
        if ($this->form_validation->submitted()) {
            if (empty($_SESSION['voter'])) {
                redirect('/auth/login');
            }

            // CSRF
            if (!Utils::validateCSRF($this->io->post('csrf_token'))) {
                Utils::flash('error', 'Invalid CSRF token.');
                redirect('/vote');
            }

            $voter = $_SESSION['voter'];
            if ($voter['has_voted']) {
                Utils::flash('info', 'You have already voted.');
                redirect('/vote/success');
            }

            $votes = $this->io->post('votes'); // array
            if (!is_array($votes)) $votes = [];

            foreach ($votes as $position => $candidate_id) {
                $cand = $this->CandidateModel->find($candidate_id);
                if ($cand) {
                    $this->VoteModel->castVote($voter['id'], $candidate_id, $position);
                }
            }

            // mark voter as voted
            $this->VoterModel->markVoted($voter['id']);
            // refresh session voter info
            $_SESSION['voter'] = $this->VoterModel->findById($voter['id']);

            // send confirmation email
            if (class_exists('Mailer')) {
                $m = new Mailer();
                $m->send($voter['email'], 'Vote Confirmation', "Hi {$voter['fullname']}, your vote was submitted. Thank you.");
            }

            Utils::flash('success', 'Your vote has been recorded.');
            redirect('/vote/success');
        }
        // if not POST, redirect to index
        redirect('/vote');
    }

    public function success()
    {
        $this->call->view('vote/results'); // reuse results view + message
    }

    // view public results (optional)
    public function results()
    {
        $tally = $this->CandidateModel->tally();
        $this->call->view('vote/results', ['tally' => $tally]);
    }
}
