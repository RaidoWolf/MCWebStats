<?php

    /*
     * Sputnik One Networks - Minecraft Web Stats
     * copyright 2014 Alexander Barber
     * distributed under the terms of the MIT License (see LICENSE for more info)
     */

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

class PlayerException extends Exception {

    //TODO

}

?>
