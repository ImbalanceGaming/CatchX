<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class play extends CI_Controller {
    public function index($side = "good")
    {
        $data = array(
            "side" => $side
        );
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
            $this->load->model('gameStateModel');
            $gameState = json_decode($this->gameStateModel->getGameStateById($id, $password));              
            $gameState = $this->gameStateModel->SetGameStateControl($side, $gameState);

            if ($side == "good")
                $gameState = $this->gameStateModel->limitDetectiveInformation( $gameState);
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
        $doubleTicket = $this->input->post('doubleTicket');
        $hiddenTicket = $this->input->post('hiddenTicket');
        
        if ($password && $id)
        {
            $this->load->database();
            $this->load->model('gameStateModel');
            $gameState = json_decode($this->gameStateModel->getGameStateById($id, $password));
            
            if ($this->gameStateModel->moveValid($gameState, $player, $position, $destination, $hiddenTicket, $doubleTicket))
            {            
                $gameState = $this->gameStateModel->doMove($gameState, $player, $position, $destination, $hiddenTicket, $doubleTicket);
                $this->gameStateModel->saveGameState($gameState, $id);
            }
            $gameState = $this->gameStateModel->SetGameStateControl($side, $gameState);

            if ($side == "good")
                $gameState = $this->gameStateModel->limitDetectiveInformation( $gameState);
            if ($gameState)
            {                    
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($gameState));
            }
        }
    }
}
