<?php

class DBConnection
{
    public static function getConnection()
    {
        include('Credentials.php');
        $path = $databaseFile;
        $db = new SQLite3($path);
        return $db;
    }

    public static function characterlist($result)
    {
        $ca = array();
        include_once('fullcharacter.php');
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

    public static function character($result)
    {
        include_once('fullcharacter.php');
        if ($result->numColumns() > 0) {
            $row = $result->fetchArray(SQLITE3_ASSOC);

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
            );
        } else {
            echo "0 results";
        }

        return $character;
    }

    public static function SelectAllCharactersbyPlayerid($id)
    {

        $ca = array();
        $conn = self::getConnection();
        $sql = "SELECT
        * from CharacterOverview
        WHERE Player_id = $id;";
        $result = $conn->query($sql);
        $ca = self::characterlist($result);
        return $ca;
    }

    public static function SelectCharacterbyCharacterid($id)
    {
        $conn = self::getConnection();
        $sql = "SELECT * FROM CharacterOverview WHERE character_id = $id";
        $result = $conn->query($sql);
        $character = self::character($result);
        return $character;
    }
    public static function ShowallBirthdaysofThisMonth($month)
    {
        include_once('fullcharacter.php');
        $conn = self::getConnection();

        $sql = "SELECT * FROM CharacterOverview WHERE Birthday IS NOT '0000-00-00' AND Birthday IS NOT null AND strftime('%m', Birthday) = '" . $month . "'
        ORDER BY Birthday";

        $result = $conn->query($sql);

        return self::characterlist($result);
    }



    public static function ShownewestCharacters()
    {
        include_once("fullcharacter.php");
        $conn = self::getConnection();

        $ca = array();

        $sql = "SELECT * FROM NewestCharacter";
        $result = $conn->query($sql);

        $ca = self::characterlist($result);

        return $ca;
    }

    public static function ShowAllPlayerCharactersWithoutPartners($id)
    {
        include_once('fullcharacter.php');
        $conn = self::getConnection();

        $sql = "SELECT * FROM SingleChars WHERE Player_id = :player_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':player_id',$id);
        $result = $stmt->execute();

        return self::characterlist($result);
    }

    public static function getallEvents()
    {
        $conn = self::getConnection();

        $sql = "SELECT * FROM AllEvents";

        $result = $conn->query($sql);

        return self::createEventList($result);
    }

    public static function createEventList($result)
    {
        $Ea = array();
        include_once('Event.php');
        if ($result->numColumns() > 0) {
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                array_push(
                    $Ea,
                    $event = new Event(
                        $row["ID"],
                        $row["LoreID"],
                        $row["Name"],
                        $row["Short_Description"],
                        $row["Description"],
                        $row["Player"],
                    )
                );
            }
        } else {
            echo "0 results";
        }
        return $Ea;
    }

    public static function getEventbyId($id)
    {
        $conn = self::getConnection();

        $sql = "SELECT * from AllEvents
        WHERE event_id = $id";

        $result = $conn->query($sql);

        return self::createEvent($result);
    }

    public static function createEvent($result)
    {
        $Ea = array();
        include_once('Event.php');
        if ($result->numColumns() > 0) {
            $row = $result->fetchArray(SQLITE3_ASSOC);
            $event = new Event(
                $row["ID"],
                $row["LoreID"],
                $row["Name"],
                $row["Short_Description"],
                $row["Description"],
                $row["Player"],
            );
        } else {
            echo "0 results";
        }
        return $event;
    }
}
