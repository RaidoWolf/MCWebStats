<?php

class Player {

    protected $stats;
    protected $uuid;

    public function __construct ($name) {

        $data = self::parsePlayerData($name);
        $this->stats = $data['stats'];
        $this->uuid = $data['uuid'];

    }

    public function getStat ($statName) {

        //TODO

    }

    public static function parsePlayerData ($name) {

        $data = [];

        //TODO
        $data['stats'] = json_decode($statsFilename);

    }

}
