<?php
class Character {
    private $id;
    private $First_Name;
    private $Last_Name;
    private $Player;
    private $Posted;
    private $Nickname;
    private $Age;
    private $Race;
    private $Birthday;
    private $Gender;
    private $Height;
    private $Weight;
    private $Child;
    private $Likes;
    private $Dislikes;
    private $Personality;
    private $Background;
    
    public function __construct($id, $First_Name, $Last_Name, $Player, $Posted, $Nickname, $Age, $Race, $Birthday, $Gender, $Height, $Weight, $Child, $Likes, $Dislikes, $Personality, $Background) {
        $this->id = $id;
        $this->First_Name = $First_Name;
        $this->Last_Name = $Last_Name;
        $this->Player = $Player;
        $this->Posted = $Posted;
        $this->Nickname = $Nickname;
        $this->Age = $Age;
        $this->Race = $Race;
        $this->Birthday = $Birthday;
        $this->Gender = $Gender;
        $this->Height = $Height;
        $this->Weight = $Weight;
        $this->Child = $Child;
        $this->Likes = $Likes;
        $this->Dislikes = $Dislikes;
        $this->Personality = $Personality;
        $this->Background = $Background;
    }

    public function getID(){
        return $this->id;
    }
    
    public function getFirstName() {
        return $this->First_Name;
    }
    
    public function getLastName() {
        return $this->Last_Name;
    }
    
    public function getPlayer() {
        return $this->Player;
    }
    
    public function getPosted() {
        return $this->Posted;
    }
    
    public function getNickname() {
        return $this->Nickname;
    }
    
    public function getAge() {
        return $this->Age;
    }
    
    public function getRace() {
        return $this->Race;
    }
    
    public function getBirthday() {
        return $this->Birthday;
    }
    
    public function getGender() {
        return $this->Gender;
    }
    
    public function getHeight() {
        return $this->Height;
    }
    
    public function getWeight() {
        return $this->Weight;
    }
    
    public function getChild() {
        return $this->Child;
    }

    public function getLikes() {
        return $this->Likes;
    }
    
    public function getDislikes() {
        return $this->Dislikes;
    }
    
    public function getPersonality() {
        return $this->Personality;
    }
    
    public function getBackground() {
        return $this->Background;
    }
}
