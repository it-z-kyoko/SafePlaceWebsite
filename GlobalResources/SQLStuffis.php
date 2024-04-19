<?php

include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/Event.php");
include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/DBConnection.php");
include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/Place.php");
include_once('C:/xampp/htdocs/SafePlaceWebsite/Classes/fullcharacter.php');
include_once('C:/xampp/htdocs/SafePlaceWebsite/Classes/Region.php');

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

function getallPlaces()
{
    $conn = DBConnection::getConnection();

    $sql = "SELECT * from lore_place";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    return createPlaceList($result);
}

function createPlaceList($result)
{
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

function getPlacebyId($placeId)
{
    $conn = DBConnection::getConnection();

    $sql = "SELECT * FROM lore_place WHERE place_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $placeId);
    $result = $stmt->execute();

    return createPlace($result);
}

function createPlace($result)
{

    if ($result->numColumns() > 0) {
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $place = new LorePlace(
            $row["place_id"],
            $row["Region_id"],
            $row["Name"],
            $row["Description"]
        );
    } else {
        echo "0 results";
    }
    return $place;
}

function getCharactersRelatedtoPlace($id)
{

    $conn = DBConnection::getConnection();

    $sql = "SELECT c.First_Name from character c
    JOIN sort_place_ruler spr on spr.character_id = c.character_id
    WHERE spr.place_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute();

    $CharacterName = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $CharacterName[] = $row['First_Name'];
    }

    return $CharacterName;
}

function getAllCharacters()
{

    $conn = DBCOnnection::getConnection();

    $sql = "SELECT * from CharacterOverview";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    return characterlist($result);
}

function characterlist($result)
{
    $ca = array();
    if ($result->numColumns() > 0) {
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            array_push(
                $ca,
                $character = new Character(
                    $row["Character_ID"],
                    $row["First_Name"],
                    $row["Middle_Name"],
                    $row["Last_Name"],
                    $row["Player_ID"],
                    $row["Posted"],
                    $row["Nickname"],
                    $row["Age"],
                    $row["Race"],
                    $row["Birthday"],
                    $row["Gender"],
                    $row["Height"],
                    $row["Weight"],
                    $row["Child"],
                    $row["Likes"],
                    $row["Dislikes"],
                    $row["Personality"],
                    $row["Background"]
                )
            );
        }
    } else {
        echo "0 results";
    }
    return $ca;
}

function getAllRegions()
{

    $conn = DBCOnnection::getConnection();

    $sql = "SELECT * from AllRegions";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    return createRegionList($result);
}

function createRegion($result)
{
    if ($result->numColumns() > 0) {
        $row = $result->fetchArray(SQLITE3_ASSOC);
        if ($row) {
            $region = new LoreRegion(
                $row['region_id'],
                $row['Name'],
                $row['Description'],
                $row['Player_id']
            );
            return $region;
        } else {
            echo "0 results";
            return null;
        }
    } else {
        echo "No columns in the result.";
        return null;
    }
}

function createRegionList($result)
{
    $regionArray = array();
    if ($result->numColumns() > 0) {
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $region = new LoreRegion(
                $row['region_id'],
                $row['Name'],
                $row['Description'],
                $row['Player_id']
            );
            array_push($regionArray, $region);
        }
        return $regionArray;
    } else {
        echo "0 results";
        return array();
    }
}

function getRegionbyId($id)
{

    $conn = DBConnection::getConnection();

    $sql = "SELECT * from AllRegions WHERE region_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $result = $stmt->execute();

    return createRegion($result);
}

function getPlacesRelatedtoRegion($region)
{
    $conn = DBConnection::getConnection();

    $sql = "SELECT * from lore_place WHERE region_id = :id;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $region);
    $result = $stmt->execute();

    return createPlaceList($result);
}

function getRulerRegion($region)
{
    $conn = DBConnection::getConnection();

    $sql = "SELECT * FROM CharacterOverview co
    JOIN sort_region_ruler srr on co.character_id = srr.character_id
    WHERE region_id = :id;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $region);
    $result = $stmt->execute();

    return characterlist($result);
}
