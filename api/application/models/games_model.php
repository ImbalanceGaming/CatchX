<?php

class Games_model extends CI_Model {


    function createGame($name, $password) {

        $this->load->model('Game_state_model');


        $this->load->helper('string');
        $id = random_string('alnum', 16);

        $data = array(
            'id' => $id,
            'name' => $name,
            'password' => $password,
            'active' => true,
            'gameState' => $this->Game_state_model->getInitialGameState()
        );

        $this->db->insert('games', $data);
        return $id;

    }

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }

    function getGames() {

        $this->db->select('name');
        $query = $this->db->get_where('games', array('active' => true));
        //$query = $this->db->query('SELECT name FROM games');
        $names = [];

        foreach ($query->result() as $row)
            array_push($names, $row->name);

        return $names;
    }

    function checkPassword($gameName, $password) {

        $query = $this->db->get_where('games', array('name' => $gameName, 'password' => $password), 1, 0);
        return $query->num_rows() == 1;
    }

    function getID($gameName, $password) {

        $query = $this->db->get_where('games', array('name' => $gameName, 'password' => $password, 'active' => true), 1, 0);
        return $query->row()->id;
    }
}

