<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class play extends CI_Controller {

    /**
     * Get the current state of a game
     */
    public function getState() {

        $gameId = $this->input->post('id');
        $side = $this->input->post('side');
        $initialLoad = $this->input->post('initialLoad');
        if ($gameId) {
            $gameState = $this->buildGameState($gameId, $initialLoad);

            if ($side == 'good') {
                $gameState = $this->limitDetectiveInformation($gameState);
            }

            if ($gameState) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($gameState));
            }
        }
    }

    /**
     * Build the map information for a game into an array
     *
     * @param int $graphId
     * @return array
     */
    public function buildMap($graphId) {

        $graph = Model\Graphs::find($graphId);

        $map = array();

        foreach ($graph->nodes() as $node) {
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

            $map['nodes'][] = $nodeData;

        }

        foreach ($graph->edges() as $edge) {
            $color = $edge->colors();
            $map['edges'][] = array(
                'node1' => (int)$edge->node1,
                'node2' => (int)$edge->node2,
                'type' => $edge->type,
                'color' => $color->hex_value
            );
        }

        return $map;

    }

    /**
     * Build the game state for a game
     *
     * @param int $gameId
     * @param bool $initialLoad set to true if you want the map information
     * @return array
     */
    public function buildGameState($gameId, $initialLoad) {

        $game = Model\Games::find($gameId);

        $gameState = array(
            "victory"                   => $game->gameStates()->victory,
            "turn"                      => (int)$game->gameStates()->turn,
            "numberOfTurns"             => (int)$game->gameStates()->number_of_turns,
            "revealTurns"               => json_decode($game->gameStates()->reveal_turns),
            "doubles"                   => (int)$game->gameStates()->doubles,
            "hiddens"                   => (int)$game->gameStates()->hiddens,
            "log"                       => ($game->gameStates()->log)?json_decode($game->gameStates()->log):"",
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

        if ($initialLoad) {
            $gameState['graph'] = $this->buildMap($game->gameStates()->graph()->id);
        }

        return $gameState;

    }

    /**
     * Process the move for a player
     */
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
            /** @var Model\GameStates $gameStateObject */
            $gameStateObject = $game = Model\Games::find($gameId)->gameStates();

            if (
                $gameStateObject->victory == "none" &&
                $gameStateObject->moveValid($playerId, $positionNodeId, $destinationNodeId, $hiddenTicket, $doubleTicket)
            ) {
                $gameStateObject->movePlayer($playerId, $destinationNodeId, $hiddenTicket, $doubleTicket);
            }

            $gameStateObject->setGameStateControl($gameStateObject->turn_side);

            $gameState = $this->buildGameState($gameId, false);

            if ($side == 'good') {
                $gameState = $this->limitDetectiveInformation($gameState);
            }

            if ($gameState) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($gameState));
            }
        }

    }

    /**
     * Used to determine if it is time to show the criminal move to the detectives
     *
     * @param array $gameState
     * @return array
     */
    private function limitDetectiveInformation($gameState) {

        if ($gameState['victory'] == 'none') {
            foreach ($gameState['players'] as $playerKey=>$player) {
                $playerObject = \Model\Players::find($player['id']);
                if ($playerObject->characters()->criminal) {
                    $gameState['players'][$playerKey]['position'] = $gameState['lastKnownJokerPosition'];
                }
            }
        }

        return($gameState);

    }

}
