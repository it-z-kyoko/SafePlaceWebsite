<?php
class LorePlace {
    private $place_id;
    private $region_id;
    private $name;
    private $description;

    public function __construct($place_id, $region_id, $name, $description) {
        $this->place_id = $place_id;
        $this->region_id = $region_id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getPlaceId() {
        return $this->place_id;
    }

    public function getRegionId() {
        return $this->region_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }
}

?>