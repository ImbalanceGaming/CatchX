<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class play extends CI_Controller {

    public function index($side = "good") {

        $data = array('side' => $side);
        $this->load->view("play/index", $data);
    }

    public function getState() {

        $id = $this->input->post('id');
        if ($id) {

            $gameState = $this->buildGameState($id);

            if ($gameState) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($gameState));
            }
        }
    }

    public function buildGameState($gameId) {

        $game = Model\Games::find($gameId);

        $gameState = array(
            "victory"                   => $game->gameStates()->victory,
            "turn"                      => (int)$game->gameStates()->turn,
            "numberOfTurns"             => (int)$game->gameStates()->number_of_turns,
            "revealTurns"               => json_decode($game->gameStates()->reveal_turns),
            "doubles"                   => (int)$game->gameStates()->doubles,
            "hiddens"                   => (int)$game->gameStates()->hiddens,
            "log"                       => $game->gameStates()->log,
            "lastKnownJokerPosition"    => (int)$game->gameStates()->last_known_joker_position,
            "turnSide"                  => $game->gameStates()->turn_side
        );

        foreach ($game->gameStates()->player() as $player) {
            $character = $player->characters();
            $gameState['players'][] = array(
                'id'        => (int)$player->id,
                'position'  => (int)$player->position,
                'turn'      => (int)$player->turn,
                'control'   => (int)$player->control,
                'pawnImage' => $character->pawnImage,
                'name'      => $character->name
            );
        }

        foreach ($game->gameStates()->graph()->nodes() as $node) {
            $nodeData = array(
                'dbId'  => (int)$node->id,
                'x'     => (int)$node->x,
                'y'     => (int)$node->y,
            );

            foreach ($node->nodeLinks() as $nodeLink) {
                $color = $nodeLink->colors();

                $nodeData['adjacent'][] = (int)$nodeLink->linked_node_id;
                $nodeData['colors'][] = $color->hex_value;
            }

            $gameState['graph']['nodes'][] = $nodeData;

        }

        foreach ($game->gameStates()->graph()->edges() as $edge) {
            $color = $edge->colors();
            $gameState['graph']['edges'][] = array(
                'node1' => (int)$edge->node1,
                'node2' => (int)$edge->node2,
                'type' => $edge->type,
                'color' => $color->hex_value
            );
        }

        return $gameState;

    }

    public function doMove() {

        $password = $this->input->post('password');
        $gameId = $this->input->post('gameId');
        $side = $this->input->post('side');
        $playerId = intval($this->input->post('playerId'));
        $positionNodeId = intval($this->input->post('positionNodeId'));
        $destinationNodeId = intval($this->input->post('destinationNodeId'));
        $doubleTicket = $this->input->post('doubleTicket') === "true";
        $hiddenTicket = $this->input->post('hiddenTicket') === "true";

        if ($password && $gameId) {
            /** @var Model\GameStates $gameState */
            $gameState = $game = Model\Games::find($gameId)->gameStates();

            if (
                $gameState->victory == "none" &&
                $gameState->moveValid($playerId, $positionNodeId, $destinationNodeId, $hiddenTicket, $doubleTicket)
            ) {
                $gameState->movePlayer($gameState, $playerId, $destinationNodeId, $hiddenTicket, $doubleTicket);
            }

            $gameState->setGameStateControl($gameState->turn_side);

            if ($gameState) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($this->buildGameState($gameId)));
            }
        }

    }
}
