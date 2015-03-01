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
        $this->load->library('form_validation');
        $this->form_validation->set_rules('gameName', 'Game name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|checkLogin');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array
            (
                'gameName'=>$name
            );

            $this->load->view("shared/header");
            $this->load->view("games/join", $data);
            $this->load->view("shared/footer");
        }
        else
        {
            $password = $this->input->post('password');
            $id = $this->gamesModel->getID($name, $password);
            
            $newdata = array(
                'id'  => $id,
                'password'   => $password,
                'name' => $name
            );
            
            $this->session->set_userdata($newdata);
            
            redirect('/games/game/', 'refresh');
        }   
    }
    
    public function CheckLogin()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        if ($this->gamesModel->checkPassword($gameName, $password))
        {
            return True;
        }
        else
        {
            $this->form_validation->set_message('CheckLogin', 'Game name or password is invalid');
            return False;
        }     
    }

    
    public function host()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('gameName', 'Game name', 'required|callback_gameNameIsUnique');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view("shared/header");
            $this->load->view('games/host');
            $this->load->view("shared/footer");
        }
        else
        {
            $password = $this->input->post('password');
            $name = $this->input->post('gameName');
            $id = $this->gamesModel->createGame($name, $password);
            
            $newdata = array(
                'id'  => $id,
                'password'   => $password,
                'name' => $name
            );
            
            $this->session->set_userdata($newdata);
            
            redirect('/games/game/', 'refresh');
        }
    }
    
    public function gameNameIsUnique($gameName)
    {
        $gameNames = $this->gamesModel->getGames();
        
        if (in_array($gameName, $gameNames))
        {
                $this->form_validation->set_message('gameNameIsUnique', 'Game name already exists');
                return FALSE;
        }
        else
        {
                return TRUE;
        }
    }
    
    public function game()
    {
        $id = $this->session->userdata('id');
        $password = $this->session->userdata('password');
        $name = $this->session->userdata('name');
        
        if ($id != null && $password != null && $name != null)
        {
            $data = array(
                'id' => $id,
                'password' => $password,
                'name' => $name
            );
            
            $this->load->view("shared/header");
            $this->load->view("games/game", $data);
            $this->load->view("shared/footer");
        }
        else
        {
            
            echo ($id);
            echo "<br/>";
            echo ($password);
            echo "<br/>";
            echo ($name);
            // TODO: Redirect to game not found page;
        }
    }
}
