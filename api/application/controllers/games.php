<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class games extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Games_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }
    
    public function Join()
    {
        $gameName = $this->input->post('gameName');
        $password = $this->input->post('password');
        
        
        $this->form_validation->set_rules('gameName', 'Game name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_checkLogin');
        $data = new stdClass();
        
        if ($this->form_validation->run() == FALSE)
        {
            $data->errors = [validation_errors()];
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        }
        else
        {
            $gameName = $this->input->post('gameName');
            $password = $this->input->post('password');
            $data->id = $this->Games_model->getID($gameName, $password);
            $data->errors = [];
            
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        }   
    }
    
    public function checkLogin($str)
    {
        $gameName = $this->input->post('gameName');
        $password = $this->input->post('password');
        
        if ($this->Games_model->checkPassword($gameName, $password))
        {
            return True;
        }
        else
        {
            $this->form_validation->set_message('checkLogin', 'Game name or password is invalid');
            return False;
        }     
    }
    
    public function Host()
    {
        $this->form_validation->set_rules('gameName', 'Game name', 'required|callback_gameNameIsUnique');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $data = new stdClass();
        
        if ($this->form_validation->run() == FALSE)
        {
            $data->errors = [validation_errors()];            
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        }
        else
        {
            $password = $this->input->post('password');
            $name = $this->input->post('gameName');
            $data->id = $this->Games_model->createGame($name, $password);
            $data->errors = [];            
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        }
    }
    
    public function gameNameIsUnique($gameName)
    {
        $gameNames = $this->Games_model->getGames();
        
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
    
    public function GameList()
    {        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->Games_model->getGames()));
    }
}
