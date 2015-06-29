<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class games extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

    }

    public function checkLogin() {

        $gameId = $this->input->post('gameId');
        $password = $this->input->post('password');

        $game = Model\Games::find($gameId);

        $data = new stdClass();

        if ($game->password === $password) {
            $data->errors = [];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } else {
            $data->errors = ['Invalid Password'];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }

    }

    public function Host() {

        $this->form_validation->set_rules('gameName', 'Game name', 'required|callback_gameNameIsUnique');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $data = new stdClass();

        if ($this->form_validation->run() == FALSE) {
            $data->errors = [validation_errors()];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } else {
            $password = $this->input->post('password');
            $name = $this->input->post('gameName');

            $game = new Model\Games();
            $game->name = $name;
            $game->password = $password;
            $game->save();
            $game->id = $game::last_created()->id;

            $mapId = Model\Graphs::find(1);

            if (empty($mapId)) {
                $data->errors = 'Cannot find map';
            } else {
                $game->createGameState($game->id, $mapId->id, [1,2,3,4,5]);
                $data->id = $game->id;
                $data->errors = [];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }

    }

    public function gameNameIsUnique($gameName) {

        $games = Model\Games::getInstance()->getGames();

        if (in_array($gameName, $games)) {
            $this->form_validation->set_message('gameNameIsUnique', 'Game name already exists');
            return FALSE;
        } else {
            return TRUE;
        }

    }

    public function gameList() {

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(Model\Games::getInstance()->getGames()));

    }

    public function createMap() {

        require_once __DIR__."/utils.php";

        $utils = new Utils();

        die(var_dump($utils->importGraphs('Batman')));

    }

}
