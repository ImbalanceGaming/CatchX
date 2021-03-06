<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;

class GameStates extends ORM {

    public $table = 'game_states';

	public $primary_key = 'id';

	function _init()
	{

        self::$relationships = array(
            'player'  => ORM::has_many('\\Model\\Players'),
            'game' => ORM::belongs_to('\\Model\\Games'),
            'graph'  => ORM::belongs_to('\\Model\\Graphs')
        );

		self::$fields = array(
			'id' => ORM::field('auto[11]'),
            'games_id' => ORM::field('int[11]'),
            'graphs_id' => ORM::field('int[11]'),
			'victory' => ORM::field('numeric[1]'),
			'turn' => ORM::field('int[11]'),
			'number_of_turns' => ORM::field('int[11]'),
			'reveal_turns' => ORM::field('char[50]'),
			'doubles' => ORM::field('int[11]'),
			'hiddens' => ORM::field('int[11]'),
			'players' => ORM::field('int[11]'),
			'log' => ORM::field('string'),
			'last_known_joker_position' => ORM::field('int[11]'),
			'turn_side' => ORM::field('char[50]'),
		);

	}

    public static function getInstance() {
        return new self;
    }

    /**
     * Make sure a player move is valid
     *
     * @param int $playerId
     * @param int $positionNodeId
     * @param int $destinationNodeId
     * @param bool $hidden
     * @param bool $double
     * @return bool
     */
    public function moveValid($playerId, $positionNodeId, $destinationNodeId, $hidden, $double) {

        /** @var \Model\Players $player */
        $player = \Model\Players::find($playerId);

        /** @var \Model\Nodes $node */
        $node = \Model\Nodes::find($positionNodeId);

        if (
            !empty($player) &&
            $player->playerExists($positionNodeId) &&
            $player->isDestinationEmpty($this->id, $destinationNodeId) &&
            $node->isNodeAdjacent($destinationNodeId) &&
            (($hidden && $this->hiddens > 0) || !$hidden) &&
            (($double && $this->doubles > 0) || !$double)
        ) {
            return true;
        }

        return false;

    }

    /**
     * Update database when a player moves
     *
     * @param int $playerId
     * @param int $destinationNodeId
     * @param bool $hidden
     * @param bool $double
     */
    public function movePlayer($playerId, $destinationNodeId, $hidden, $double) {

        /** @var \Model\Players $player */
        $player = \Model\Players::find($playerId);
        $currentNode = \Model\Nodes::find($player->position);
        $game = $this->game();

        $player->position = $destinationNodeId;
        $player->turn = false;

        $player->save();

        if ($player->characters()->criminal) {
            foreach ($currentNode->nodeLinks() as $nodeLink) {
                if ($nodeLink->linked_node_id == $destinationNodeId) {
                    $color = $nodeLink->colors()->hex_value;
                }
            }
            $this->criminalMove($game, $player, $hidden, $double, $color);
        } else {
            $this->detectiveMove($game, $player);
        }

        $player->save();

    }

    /**
     * Set which players current have control of their characters
     *
     * @param string $side
     */
    public function setGameStateControl($side) {

        $criminalControl = false;
        $detectiveControl = false;

        if ($side == "good") {
            $criminalControl = false;
            $detectiveControl = true;
        } else if ($side == "evil") {
            $criminalControl = true;
            $detectiveControl = false;
        }

        foreach ($this->player() as $player) {
            if (!$player->characters()->criminal) {
                $player->control = $detectiveControl;
            } else {
                $player->control = $criminalControl;
            }
            $player->save();
        }

    }

    /**
     * Process the criminal turn
     *
     * @param \Model\Games $game
     * @param \Model\Players $player
     * @param int $hidden
     * @param int $double
     * @param string $color
     */
    private function criminalMove(&$game, &$player, $hidden, $double, $color) {

        //Check if joker used a hidden
        if ($hidden) {
            $this->hiddens--;
            $color = "#800080";
        }

        //Check if joker used a double
        if ($double) { //If he does he keeps te turn
            $this->doubles--;
            $player->turn = true;
        } else { //Else the turn goes to the batman team
            $this->turn_side = "good";
            foreach ($this->player() as $player2) {
                if (!$player2->characters()->criminal) {
                    $player2->turn = true;
                    $player2->save();
                }
            }
            $player->turn = false;
        }

        //Increment turn
        $this->turn++;

        //Check if the jokoker reveals himself and update the log
        if (in_array($this->turn, json_decode($this->reveal_turns))) {
            $this->last_known_joker_position = $player->position;
            $this->updateLog($color, $player->position);
        } else {
            $this->updateLog($color);
        }

        //Check if the joker has won
        if ($this->turn == $this->numberOfTurns) {
            $this->victory = "evil";
            $game->active = false;
            $game->save();
        }

        //Give the joker control    TODO (this need to be refactored out)
        foreach ($this->player() as $player2) {
            if (!$player2->characters()->criminal) {
                $player2->control = false;
                $player2->save();
            }
        }
        $player->control = true;

        $this->save();

    }

    /**
     * Process the detective move
     *
     * @param \Model\Games $game
     * @param \Model\Players $player
     */
    private function detectiveMove(&$game, &$player) {

        $turnOver = true;
        /** @var \Model\Players $evilPlayer */
        $evilPlayer = null;
        foreach ($this->player() as $player2) {
            if (!$player2->characters()->criminal && $player2->turn) {
                $turnOver = false;
            } elseif ($player2->characters()->criminal) {
                $evilPlayer = $player2;
            }
        }

        if ($turnOver) {
            $this->turn_side = "evil";
            $evilPlayer->turn = true;
            $evilPlayer->save();
        }

        if ($player->position == $evilPlayer->position) {
            $this->victory = "good";
            $game->active = false;
            $game->save();
        }

        $this->save();

    }

    /**
     * Update the game log depending on the criminal move
     *
     * @param $color
     * @param null $position
     */
    private function updateLog($color, $position = null) {

        if (!empty($position)) {
            $log = json_decode($this->log);
            $log[] = array('color' => $color, 'position' => $position);
            $this->log = json_encode($log);
        } else {
            $log = json_decode($this->log);
            $log[] = array('color' => $color);
            $this->log = json_encode($log);
        }


    }

}