<?php
class Event
{
    private $id;

    private $LoreId;

    private $Name;

    private $Description;

    private $Player;

    private $Short_Description;

    public function __construct($id, $LoreId, $Name, $short_Description, $description, $Player)
    {
        $this->id = $id;
        $this->Description = $description;
        $this->Name = $Name;
        $this->LoreId = $LoreId;
        $this->Player = $Player;
        $this->Short_Description = $short_Description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLoreId()
    {
        return $this->LoreId;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getDescription()
    {
        return $this->Description;
    }

    public function getPlayer()
    {
        return $this->Player;
    }

    public function getShortDescription()
    {
        return $this->Short_Description;
    }
}
