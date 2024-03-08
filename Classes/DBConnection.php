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
        FROM `characters` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profiles` AS cpn ON c.character_id = cpn.characters_id
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
        FROM `characters` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profiles` AS cpn ON c.character_id = cpn.characters_id WHERE c.character_id = $id";
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
        FROM `characters` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profiles` AS cpn ON c.character_id = cpn.characters_id
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
        FROM `characters` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profiles` AS cpn ON c.character_id = cpn.characters_id ORDER BY c.Posted DESC LIMIT 5";
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
        FROM `characters` AS c
        LEFT JOIN `character_personality` AS cp ON c.character_id = cp.character_id
        LEFT JOIN `character_profiles` AS cpn ON c.character_id = cpn.characters_id 
        ORDER BY Posted
        DESC
        LIMIT 5;";
        $result = $conn->query($sql);

        $ca = self::characterlist($result);

        return $ca;
    }
}
