<?php

class GamesModel extends CI_Model {

    
    
    function getGames()
    {
        $query = $this->db->query('SELECT name FROM games');
        $names = [];
        
        foreach ($query->result() as $row)
            array_push($names, $row->name);
        
        return $names;
    }
    
    function CheckXPassword($gameName, $xPassword)
    {        
        $query = $this->db->get_where('games', array('name' => $gameName,'xPassword' => $xPassword), 1, 0);
        return $query->num_rows() == 1;
    }
    
    function CheckdetectivePassword($gameName, $detectivePassword)
    {        
        $query = $this->db->get_where('games', array('name' => $gameName,'xPassword' => $detectivePassword), 1, 0);
        return $query->num_rows() == 1;
    }

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
}

