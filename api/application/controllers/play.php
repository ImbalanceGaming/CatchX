<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class play extends CI_Controller {

    public function index($side = "good") {

        $data = array('side' => $side);
        $this->load->view("play/index", $data);
    }

    public function getState() {

        $id = $this->input->post('id');
        $side = $this->input->post('side');
        if ($id) {
            $game = Model\Games::find($id);

            $gameState = array(
                "victory"                   => $game->gameStates()->victory,
                "turn"                      => $game->gameStates()->turn,
                "numberOfTurns"             => $game->gameStates()->number_of_turns,
                "revealTurns"               => $game->gameStates()->reveal_turns,
                "doubles"                   => $game->gameStates()->doubles,
                "hiddens"                   => $game->gameStates()->hiddens,
                "log"                       => $game->gameStates()->log,
                "lastKnownJokerPosition"    => $game->gameStates()->last_known_joker_position,
                "turnSide"                  => $game->gameStates()->turn_side
            );

            foreach ($game->gameStates()->player() as $player) {
                $character = $player->characters();
                $gameState['players'][] = array(
                    'position'  => $player->position,
                    'turn'      => $player->turn,
                    'control'   => $player->control,
                    'pawnImage' => $character->pawnImage,
                    'name'      => $character->name
                );
            }

            foreach ($game->gameStates()->graph()->nodes() as $node) {
                $nodeData = array(
                    'x' => $node->x,
                    'y' => $node->y,
                );

                foreach ($node->nodeLinks() as $nodeLink) {
                    $color = $nodeLink->colors();

                    $nodeData['adjacent'][] = $nodeLink->linked_node_id;
                    $nodeData['colors'][] = $color->hex_value;
                }

                $gameState['graph']['nodes'][] = $nodeData;

            }

            foreach ($game->gameStates()->graph()->edges() as $edge) {
                $color = $edge->colors();
                $gameState['graph']['edges'][] = array(
                    'node1' => $edge->node1,
                    'node2' => $edge->node2,
                    'type' => $edge->type,
                    'color' => $color->hex_value
                );
            }

//            if ($side == "good") {
//                $gameState = $this->Game_state_model->limitDetectiveInformation($gameState);
//                if ($game->gameStates()->victory == "none") {
//                    $gameState['players'][0]->position = $game->gameStates()->last_known_joker_position;
//                }
//            }

            if ($gameState) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($gameState));
            }
        }
    }

    public function doMove() {

        $password = $this->input->post('password');
        $id = $this->input->post('id');
        $side = $this->input->post('side');
        $player = intval($this->input->post('player'));
        $position = intval($this->input->post('position'));
        $destination = intval($this->input->post('destination'));
        $doubleTicket = $this->input->post('doubleTicket') === "true";
        $hiddenTicket = $this->input->post('hiddenTicket') === "true";

        if ($password && $id) {
            $this->load->database();
            $this->load->model('Game_state_model');
            $gameState = json_decode($this->Game_state_model->getGameStateById($id, $password));

            if ($gameState->victory == "none" && $this->Game_state_model->moveValid($gameState, $player, $position, $destination, $hiddenTicket, $doubleTicket)) {
                $gameState = $this->Game_state_model->doMove($gameState, $player, $position, $destination, $hiddenTicket, $doubleTicket);
                $this->Game_state_model->saveGameState($gameState, $id);
            }
            $gameState = $this->Game_state_model->SetGameStateControl($side, $gameState);

            if ($side == "good") {
                $gameState = $this->Game_state_model->limitDetectiveInformation($gameState);
            }

            if ($gameState->victory != "none") {
                $this->Game_state_model->deactivateGameState($id);
            }

            if ($gameState) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($gameState));
            }
        }
    }
}
