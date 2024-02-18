<?php
class tickets
{
    private $problem;
    private $Player;
    private $id;

    public function __construct($problem,$Player,$id)
    {
        $this->problem = $problem;
        $this->Player = $Player;
        $this->id = $id;
    }

    public function getProblem(){
        return $this->problem;
    }

    public function getPlayer(){
        return $this->Player;
    }

    public function getid(){
        return $this->id;
    }
}

?>