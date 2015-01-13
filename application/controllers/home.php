<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {
	public function index()
	{
            $this->load->view("shared/header");
            $this->load->view('home/index');
            $this->load->view("shared/footer");
	}
}
