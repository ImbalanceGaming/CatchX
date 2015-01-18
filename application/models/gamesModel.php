<?php

class GamesModel extends CI_Model {

    function createGame($name, $password)
    {
        $this->load->model('gameStateModel');
        
        if (!nameExistsAndGameIsActive($name))
        {
            $data = array(
            'name' => $name ,
            'password' => $password ,
            'active' => true ,
            'gameState' => getInitialGameState()
         );

         $this->db->insert('mytable', $data); 
        }
        else
        {
            return false;
        }
    }
    
    function nameExistsAndGameIsActive($name)
    {
        $this->db->where('name', $name); 
        $this->db->where('active', true); 
        $query = $this->db->get('games');
        
        if ($query->num_rows() > 1)
        {
            # TODO: add error handling or post a log 
        }
        
        if ($query->num_rows() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function getGames()
    {
        $this->db->where('active', true);
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

