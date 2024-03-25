<?php
function CreateDatabase()
{
    $databaseFile = 'Database/SafePlace.db';

    try {
        $db = new SQLite3($databaseFile);

        // `character` Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS character (
        character_id INTEGER PRIMARY KEY AUTOINCREMENT,
        First_Name TEXT,
        Last_Name TEXT,
        Player_id INTEGER,
        Posted DATE,
        Created DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (Player_id) REFERENCES players(id)
    )');

        // character_ability Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS character_ability (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        character_id INTEGER,
        Description TEXT NOT NULL,
        Inherit INTEGER,
        FOREIGN KEY (character_id) REFERENCES `character`(character_id) ON DELETE CASCADE
    )');

        // character_family Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS character_family (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        character_id INTEGER,
        Parent1 INTEGER,
        Parent2 INTEGER,
        Grandparent1 INTEGER,
        Grandparent2 INTEGER,
        Grandparent3 INTEGER,
        Grandparent4 INTEGER,
        Sibling TEXT,
        Aunt TEXT,
        Uncle TEXT,
        Child TEXT,
        Partner INTEGER,
        Married INTEGER,
        FOREIGN KEY (character_id) REFERENCES `character`(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Parent1) REFERENCES `character`(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Parent2) REFERENCES `character`(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent1) REFERENCES `character`(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent2) REFERENCES `character`(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent3) REFERENCES `character`(character_id),
        FOREIGN KEY (Grandparent4) REFERENCES `character`(character_id),
        FOREIGN KEY (Partner) REFERENCES `character`(character_id) ON DELETE CASCADE
    )');

        // character_personality Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS character_profile (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        characters_id INTEGER,
        Nickname TEXT,
        Age INTEGER,
        Race TEXT,
        Birthday DATE,
        Gender TEXT,
        Height INTEGER,
        Weight INTEGER,
        Child INTEGER,
        FOREIGN KEY (characters_id) REFERENCES `character`(character_id) ON DELETE NO ACTION
    )');

        // character_profile Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS players (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        Name TEXT NOT NULL,
        Birthday DATE,
        Last_Log_In DATE
    )');

        // players Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS tickets (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        Player_id INTEGER,
        Problem TEXT NOT NULL,
        Created DATETIME DEFAULT CURRENT_TIMESTAMP,
        Solved INTEGER NOT NULL DEFAULT 0,
        FOREIGN KEY (Player_id) REFERENCES players(id)
    )');

        // tickets Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS user (
        User_id INTEGER PRIMARY KEY AUTOINCREMENT,
        Player_id INTEGER,
        Username TEXT NOT NULL,
        Password TEXT NOT NULL,
        Last_login DATE NOT NULL,
        FOREIGN KEY (Player_id) REFERENCES players(id) ON DELETE CASCADE
    )');

        // user Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS wishlist (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        Player_id INTEGER,
        Description TEXT NOT NULL,
        FOREIGN KEY (Player_id) REFERENCES players(id)
    )');

        // wishlist Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS character_personality (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        character_id INTEGER UNIQUE,
        Likes TEXT,
        Dislikes TEXT,
        Personality TEXT,
        Background TEXT,
        FOREIGN KEY (character_id) REFERENCES `character`(character_id) ON DELETE CASCADE
    )');
    } catch (Exception $e) {
        die('Fehler beim Erstellen der Tabellen: ' . $e->getMessage());
    }
}

function ShowFamily($id)
{
    $searching = $id;

    $conn = DBConnection::getConnection();

    // SQL-Abfrage für den gewünschten Datensatz (Using prepared statement to prevent SQL injection)
    $sql = "SELECT * FROM character_family_role WHERE character_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $searching, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result) {
        function extractNames($id, $conn)
        {
            if ($id != "") {
                $sql = "SELECT `First_Name` FROM `character` WHERE character_id = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1, $id, SQLITE3_NUM);
                $nameResult = $stmt->execute();

                if ($nameResult) {  // Check if the query execution was successful
                    $row = $nameResult->fetchArray(SQLITE3_ASSOC);

                    if ($row !== false) {
                        $name = $row['First_Name'];
                        $result = "<a href='Character.php?id=$id'>$name</a>";
                    } else {
                        $result = "Name not found for ID: $id";
                    }
                }
            }
            return $result;
        }

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            switch ($row['Role']) {
                case 'Parent':
                    $Parent[] = extractNames($row["Connected_Character"], $conn);
                    break;
                case 'Sibling':
                    $Sibling[] = extractNames($row["Connected_Character"], $conn);
                    break;
                case 'Child':
                    $Child[] = extractNames($row["Connected_Character"], $conn);
                    break;
                case 'Partner':
                    $Partner = extractNames($row["Connected_Character"], $conn);
                    break;
                default:
                    break;
            }
        }

        $output = "<table class='character-info'>";

        if (!empty($Parent)) {
            $output .= "<tr><th>Eltern</th>";
            foreach ($Parent as $p) {
                $output .= "<td>$p</td>";
            }
            $output .= "</tr>";
        }

        if (!empty($Sibling)) {
            $output .= "<tr><th>Geschwister</th>";
            foreach ($Sibling as $s) {
                $output .= "<td>$s</td>";
            }
            $output .= "</tr>";
        }

        if (!empty($Child)) {
            $output .= "<tr><th>Kinder</th>";
            foreach ($Child as $c) {
                $output .= "<td>$c</td>";
            }
            $output .= "</tr>";
        }

        if (!empty($Partner)) {
            $output .= "<tr><th>Partner</th>";
            $output .= "<td>$Partner</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";

        echo $output;
    } else {
        echo "Keine Daten gefunden.";
    }

    // Datenbankverbindung schließen
    $conn->close();
}


function ShowAbilities($id)
{
    include_once('../Classes/Abilities.php');
    $conn = DBConnection::getConnection();

    $sql = "SELECT * FROM character_ability WHERE character_id = $id";
    $result = $conn->query($sql);

    $ab = array();

    if ($result->numColumns() > 0) {
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ability = new Abilities(
                $row["character_id"],
                $row["Description"]
            );
            array_push($ab, $ability);
        }
    }

    if (!empty($ab)) {
        echo "<ul>";
        foreach ($ab as $ability) {
            echo "<li>" . $ability->getDescription() . "</li>";
        }
        echo "</ul>";
    }
}
