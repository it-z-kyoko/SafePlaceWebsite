<?php
class DBConnection
{
    private static string $databaseFile = 'C:\xampp\htdocs\SafePlaceWebsite\Database\SafePlace.db';
    //TODO: Pfad Austauschen!
    public static function getConnection()
    {
        $path = self::$databaseFile;
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
        c.character_id AS Character_ID,
        c.First_Name AS First_Name,
        c.Last_Name AS Last_Name,
        c.Player_id AS Player_ID,
        c.Posted AS Posted,
        cpn.Nickname AS Nickname,
        cpn.Age AS Age,
        cpn.Race AS Race,
        cpn.Birthday AS Birthday,
        cpn.Gender AS Gender,
        cpn.Height AS Height,
        cpn.Weight AS Weight,
        cpn.Child AS Child,
        cp.Likes AS Likes,
        cp.Dislikes AS Dislikes,
        cp.Personality AS Personality,
        cp.Background AS Background
        FROM `character` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profile` AS cpn ON c.character_id = cpn.characters_id
        WHERE c.Player_id = $id;";
        $result = $conn->query($sql);
        $ca = self::characterlist($result);
        return $ca;
    }

    public static function SelectCharacterbyCharacterid($id)
    {
        $conn = self::getConnection();
        $sql = "SELECT
        c.character_id AS Character_ID,
        c.First_Name AS First_Name,
        c.Last_Name AS Last_Name,
        c.Player_id AS Player_ID,
        c.Posted AS Posted,
        cpn.Nickname AS Nickname,
        cpn.Age AS Age,
        cpn.Race AS Race,
        cpn.Birthday AS Birthday,
        cpn.Gender AS Gender,
        cpn.Height AS Height,
        cpn.Weight AS Weight,
        cpn.Child AS Child,
        cp.Likes AS Likes,
        cp.Dislikes AS Dislikes,
        cp.Personality AS Personality,
        cp.Background AS Background
        FROM `character` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profile` AS cpn ON c.character_id = cpn.characters_id WHERE c.character_id = $id";
        $result = $conn->query($sql);
        $character = self::character($result);
        return $character;
    }
    public static function ShowallBirthdaysofThisMonth($month)
    {
        include_once('fullcharacter.php');
        $conn = self::getConnection();

        $sql = "SELECT
        c.character_id AS Character_ID,
        c.First_Name AS First_Name,
        c.Last_Name AS Last_Name,
        c.Player_id AS Player_ID,
        c.Posted AS Posted,
        cpn.Nickname AS Nickname,
        cpn.Age AS Age,
        cpn.Race AS Race,
        cpn.Birthday AS Birthday,
        cpn.Gender AS Gender,
        cpn.Height AS Height,
        cpn.Weight AS Weight,
        cpn.Child AS Child,
        cp.Likes AS Likes,
        cp.Dislikes AS Dislikes,
        cp.Personality AS Personality,
        cp.Background AS Background
        FROM `character` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profile` AS cpn ON c.character_id = cpn.characters_id
        WHERE cpn.Birthday IS NOT '0000-00-00' AND cpn.Birthday IS NOT null AND strftime('%m', cpn.Birthday) = '" . $month . "'
        ORDER BY cpn.Birthday";

        $result = $conn->query($sql);

        return self::characterlist($result);
    }



    public static function ShownewestCharacters()
    {
        include_once("fullcharacter.php");
        $conn = self::getConnection();

        $ca = array();

        $sql = "SELECT
        c.character_id AS Character_ID,
        c.First_Name AS First_Name,
        c.Last_Name AS Last_Name,
        c.Player_id AS Player_ID,
        c.Posted AS Posted,
        cpn.Nickname AS Nickname,
        cpn.Age AS Age,
        cpn.Race AS Race,
        cpn.Birthday AS Birthday,
        cpn.Gender AS Gender,
        cpn.Height AS Height,
        cpn.Weight AS Weight,
        cpn.Child AS Child,
        cp.Likes AS Likes,
        cp.Dislikes AS Dislikes,
        cp.Personality AS Personality,
        cp.Background AS Background
        FROM `character` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profile` AS cpn ON c.character_id = cpn.characters_id ORDER BY c.Posted DESC LIMIT 5";
        $result = $conn->query($sql);

        $ca = self::characterlist($result);

        return $ca;
    }

    public static function ShowNewsSinceLastLogIn($id)
    {
        include_once("fullcharacter.php");
        $conn = self::getConnection();

        $ca = array();

        $sql = "SELECT
        c.character_id AS Character_ID,
        c.First_Name AS First_Name,
        c.Last_Name AS Last_Name,
        c.Player_id AS Player_ID,
        c.Posted AS Posted,
        c.Created AS Created,
        cpn.Nickname AS Nickname,
        cpn.Age AS Age,
        cpn.Race AS Race,
        cpn.Birthday AS Birthday,
        cpn.Gender AS Gender,
        cpn.Height AS Height,
        cpn.Weight AS Weight,
        cpn.Child AS Child,
        cp.Likes AS Likes,
        cp.Dislikes AS Dislikes,
        cp.Personality AS Personality,
        cp.Background AS Background
        FROM `character` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profile` AS cpn ON c.character_id = cpn.characters_id 
        ORDER BY Posted
        DESC
        LIMIT 5;";
        $result = $conn->query($sql);

        $ca = self::characterlist($result);

        return $ca;
    }

    public static function ShowAllPlayerCharactersWithoutPartners($id)
    {
        include_once('fullcharacter.php');
        $conn = self::getConnection();

        switch ($id) {
            case 1:
                $sql = "SELECT * FROM KyoSingleChars";
                break;
            case 2:
                $sql = "SELECT * FROM LeaSingleChars";
                break;
            case 3:
                $sql = "SELECT * FROM AnniSingleChars";
                break;
            default:
                break;
        }
        $result = $conn->query($sql);

        return self::characterlist($result);
    }

    public static function getallEvents()
    {
        $conn = self::getConnection();

        $sql = "SELECT le.event_id as ID, 
        le.Lore_id as LoreID, 
        le.Name as `Name`, 
        le.Description as `Description`,
        le.Short_Description as `Short_Description`, 
        le.Player_id as Player 
        FROM `lore_event` as le";

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

        $sql = "SELECT le.event_id as ID, 
        le.Lore_id as LoreID, 
        le.Name as `Name`, 
        le.Description as `Description`,
        le.Short_Description as `Short_Description`, 
        le.Player_id as Player 
        FROM `lore_event` as le
        WHERE le.event_id = $id";

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
