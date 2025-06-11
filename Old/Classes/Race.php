<?php

class Race {
    private $raceID;
    private $playerid;
    private $name;
    private $description;
    private $personality;
    private $bodyDescription;
    private $relationships;
    private $alignment;
    private $landOrigin;
    private $religion;
    private $language;
    private $names;

    public function __construct($raceID, $playerID, $name,$description, $personality, $bodyDescription, $relationships, $alignment, $landOrigin, $religion, $language, $names) {
        $this->raceID = $raceID;
        $this->playerid = $playerID;
        $this->name = $name;
        $this->description = $description;
        $this->personality = $personality;
        $this->bodyDescription = $bodyDescription;
        $this->relationships = $relationships;
        $this->alignment = $alignment;
        $this->landOrigin = $landOrigin;
        $this->religion = $religion;
        $this->language = $language;
        $this->names = $names;
    }
    
    public function getRaceID() {
        return $this->raceID;
    }
    
    public function setRaceID($raceID) {
        $this->raceID = $raceID;
    }
    
    public function getPlayer() {
        return $this->playerid;
    }
    
    public function setPlayer($playerID) {
        $this->playerid = $playerID;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getPersonality() {
        return $this->personality;
    }
    
    public function setPersonality($personality) {
        $this->personality = $personality;
    }
    
    public function getBodyDescription() {
        return $this->bodyDescription;
    }
    
    public function setBodyDescription($bodyDescription) {
        $this->bodyDescription = $bodyDescription;
    }
    
    public function getRelationships() {
        return $this->relationships;
    }
    
    public function setRelationships($relationships) {
        $this->relationships = $relationships;
    }
    
    public function getAlignment() {
        return $this->alignment;
    }
    
    public function setAlignment($alignment) {
        $this->alignment = $alignment;
    }
    
    public function getLandOrigin() {
        return $this->landOrigin;
    }
    
    public function setLandOrigin($landOrigin) {
        $this->landOrigin = $landOrigin;
    }
    
    public function getReligion() {
        return $this->religion;
    }
    
    public function setReligion($religion) {
        $this->religion = $religion;
    }
    
    public function getLanguage() {
        return $this->language;
    }
    
    public function setLanguage($language) {
        $this->language = $language;
    }
    
    public function getNames() {
        return $this->names;
    }
    
    public function setNames($names) {
        $this->names = $names;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}

?>
