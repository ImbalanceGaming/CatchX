<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;

class Nodes extends ORM {

    public $primary_key = 'id';

    function _init() {

        self::$relationships = array(
            'nodeLinks' => ORM::has_many('\\Model\\NodeLinks'),
            'graphs' => ORM::belongs_to('\\Model\\Graphs')
        );

        self::$fields = array(
            'id' => ORM::field('auto[11]'),
            'graphs_id' => ORM::field('int[11]'),
            'x' => ORM::field('int[11]'),
            'y' => ORM::field('int[11]')
        );

    }

    /**
     * Check if a player is currently in a node
     *
     * @param int $nodeId
     * @return bool
     */
    public function isNodeAdjacent($nodeId) {

        $nodeLinks = $this->nodeLinks();

        foreach ($nodeLinks as $nodeLink) {
            if ($nodeLink->linked_node_id == $nodeId) {
                return true;
            }
        }

        return false;

    }

}