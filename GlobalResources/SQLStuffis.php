<?php

include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/Event.php");
include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/DBConnection.php");

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

function getallEvents() {

    include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/Lore.php");

    $conn = DBCOnnection::getConnection();

    $sql = "SELECT * FROM lore";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    $Lore = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        array_push($Lore, $l = new Lore($row["id"],$row["Name"],$row["Description"]));
    }

    return $Lore;
}
