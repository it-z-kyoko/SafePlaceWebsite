<?php

include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/Event.php");
include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/DBConnection.php");
include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/Place.php");

function getCharacterRelatedToLore($id)
{
    $conn = DBConnection::getConnection();

    $sql = "SELECT c.First_Name AS FirstName 
    FROM character c 
    JOIN sort_event_character sec ON c.character_id = sec.character_id
    JOIN lore_event le ON sec.event_id = le.event_id
    WHERE le.lore_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $firstNames = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $firstNames[] = $row['FirstName'];
    }

    return $firstNames;
}

function getRaceRelatedToLore($id)
{

    $conn = DBConnection::getConnection();

    $sql = "SELECT r.Name AS name
    FROM lore_race as r
    JOIN sort_race_event sre ON r.race_id = sre.race_id
    JOIN lore_event le ON sre.Event_id = le.event_id
    WHERE le.lore_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $RaceNames = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $RaceNames[] = $row['Name'];
    }

    return $RaceNames;
}

function getallEvents()
{
    include_once("../../Classes/DBConnection.php");
    include_once("../../Classes/Lore.php");

    $conn = DBConnection::getConnection();

    $sql = "SELECT * FROM lore";

    $stmt = $conn->prepare($sql);
    $restult = $stmt->execute();

    $Lore = array();
    while ($row = $restult->fetchArray(SQLITE3_ASSOC)) {
        $lore = new Lore($row["id"], $row["Name"], $row["Description"]);
        $Lore[] = $lore;
    }

    return $Lore;
}

function getCharacterRelatedToEvent($event)
{

    $conn = DBConnection::getConnection();

    $sql = "SELECT c.First_Name as name FROM character c
    JOIN sort_event_character sec on c.character_id = sec.character_id
    WHERE sec.event_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $event, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $CharacterName = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $CharacterName[] = $row['name'];
    }

    return $CharacterName;
}

function getRacesRelatedToEvent($event)
{
    $conn = DBConnection::getConnection();

    $sql = "SELECT r.Name From lore_race r
    JOIN sort_race_event sre on r.race_id = sre.race_id
    WHERE event_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $event, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $RaceArray = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $RaceArray[] = $row['Name'];
    }

    return $RaceArray;
}

function getEventsRelatedtoRace($race)
{
    $conn = DBConnection::getConnection();

    $sql = "SELECT e.Name FROM lore_event e
    JOIN sort_race_event sre on e.event_id = sre.event_id
    WHERE race_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $race, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $RaceArray = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $RaceArray[] = $row['Name'];
    }

    return $RaceArray;
}

function getCharacterRelatedToRace($race)
{

    $conn = DBConnection::getConnection();

    $sql = "SELECT c.First_Name as name FROM character c
    JOIN sort_race_character sec on c.character_id = sec.character_id
    WHERE sec.race_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $race, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $CharacterName = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $CharacterName[] = $row['name'];
    }

    return $CharacterName;
}

function getallPlaces() {
    $conn = DBConnection::getConnection();

    $sql = "SELECT * from lore_place";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    return createPlaceList($result);
}

function createPlaceList($result) {
    $placeArray = array();
    if ($result->numColumns() > 0) {
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $place = new LorePlace(
                $row["place_id"],
                $row["Region_id"],
                $row["Name"],
                $row["Description"]
            );
            array_push($placeArray, $place);
        }
    } else {
        echo "0 results";
    }
    return $placeArray;
}