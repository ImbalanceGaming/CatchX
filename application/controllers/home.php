<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {
	public function index()
	{
            $this->load->view("shared/header");
            $this->load->view('home/indexTop');
            $this->load->view('games/index');
            $this->load->view('games/join');
            $this->load->view('games/host');
            $this->load->view('home/indexBottom');
            $this->load->view("shared/footer");
	}
}
