<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class play extends CI_Controller {
    public function index($side = "good")
    {
        $data = array('side' => $side);
        $this->load->view("play/index", $data);
    }

    public function getState()
    {            
        $password = $this->input->post('password');
        $id = $this->input->post('id');
        $side = $this->input->post('side');
        if ($password && $id)
        {
            $this->load->database();
            $this->load->model('Game_state_model');
            $gameState = json_decode($this->Game_state_model->getGameStateById($id, $password));
            $gameState = $this->Game_state_model->SetGameStateControl($side, $gameState);

            if ($side == "good")
                $gameState = $this->Game_state_model->limitDetectiveInformation( $gameState);
            
            if ($gameState)
            {                    
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($gameState));
            }
        }
    }

    public function doMove()
    {
        $password = $this->input->post('password');
        $id = $this->input->post('id');
        $side = $this->input->post('side');
        $player = intval($this->input->post('player'));
        $position = intval($this->input->post('position'));
        $destination = intval($this->input->post('destination'));
        $doubleTicket = $this->input->post('doubleTicket') === "true";
        $hiddenTicket = $this->input->post('hiddenTicket') === "true";
        
        if ($password && $id)
        {
            $this->load->database();
            $this->load->model('Game_state_model');
            $gameState = json_decode($this->Game_state_model->getGameStateById($id, $password));
            
            if ($gameState->victory == "none" && $this->Game_state_model->moveValid($gameState, $player, $position, $destination, $hiddenTicket, $doubleTicket))
            {            
                $gameState = $this->Game_state_model->doMove($gameState, $player, $position, $destination, $hiddenTicket, $doubleTicket);
                $this->Game_state_model->saveGameState($gameState, $id);
            }
            $gameState = $this->Game_state_model->SetGameStateControl($side, $gameState);

            if ($side == "good")
                $gameState = $this->Game_state_model->limitDetectiveInformation( $gameState);
            
            if ($gameState->victory != "none")
                $this->Game_state_model->deactivateGameState($id);
            
            if ($gameState)
            {                    
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($gameState));
            }
        }
    }
}