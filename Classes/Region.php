<?php
class LoreRegion {
    private $region_id;
    private $name;
    private $description;
    private $player_id;

    // Konstruktor
    public function __construct($region_id, $name, $description, $player_id) {
        $this->region_id = $region_id;
        $this->name = $name;
        $this->description = $description;
        $this->player_id = $player_id;
    }

    // Getter für Region ID
    public function getRegionId() {
        return $this->region_id;
    }

    // Getter für Name
    public function getName() {
        return $this->name;
    }

    // Getter für Description
    public function getDescription() {
        return $this->description;
    }

    // Getter für Player ID
    public function getPlayerId() {
        return $this->player_id;
    }
}

?>