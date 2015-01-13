<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class games extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('gamesModel');
    }
    
    public function index()
    {
        $gameNames = $this->gamesModel->getGames();
        $data = array(
            'gameNames' => $gameNames
        );
        
        $this->load->view("shared/header");
        $this->load->view('games/index', $data);
        $this->load->view("shared/footer");
    }
    
    public function join($name)
    {
        $this->load->view("shared/header");
        $this->load->view("shared/footer");
    }
    
    public function host()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('gameName', 'Game name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view("shared/header");
            $this->load->view('games/host');
            $this->load->view("shared/footer");
        }
        else
        {
            $this->load->view("shared/header");
            //$this->load->view('games/index', $games);
            $this->load->view("shared/footer");
            //redirect('/games/hostSucces/', 'refresh');
        }
    }
}
