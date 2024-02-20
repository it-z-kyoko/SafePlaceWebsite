<?php
function CreateDatabase()
{
    $databaseFile = 'Database/SafePlace.db';

    try {
        $db = new SQLite3($databaseFile);

        // characters Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS characters (
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
        Describtion TEXT NOT NULL,
        Inherit INTEGER,
        FOREIGN KEY (character_id) REFERENCES characters(character_id) ON DELETE CASCADE
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
        FOREIGN KEY (character_id) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Parent1) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Parent2) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent1) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent2) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent3) REFERENCES characters(character_id),
        FOREIGN KEY (Grandparent4) REFERENCES characters(character_id),
        FOREIGN KEY (Partner) REFERENCES characters(character_id) ON DELETE CASCADE
    )');

        // character_personality Tabelle
        $db->exec('CREATE TABLE IF NOT EXISTS character_profiles (
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
        FOREIGN KEY (characters_id) REFERENCES characters(character_id) ON DELETE NO ACTION
    )');

        // character_profiles Tabelle
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
        Describtion TEXT NOT NULL,
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
        FOREIGN KEY (character_id) REFERENCES characters(character_id) ON DELETE CASCADE
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
    $sql = "SELECT * FROM character_family WHERE character_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $searching, SQLITE3_TEXT);
    $result = $stmt->execute();
    

    // Überprüfen, ob ein Datensatz gefunden wurde
    if ($result->numColumns() > 0) {
        $row = $result->fetchArray(SQLITE3_ASSOC);

        // Funktion zum Extrahieren von Namen aus komma-separierten Listen
        function extractNames($list, $conn)
        {
            $names = explode(",", $list);
            $result = array();

            foreach ($names as $id) {
                if ($id != "") {
                    $sql = "SELECT `First_Name` FROM characters WHERE character_id = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(1, $id, SQLITE3_NUM);
                    $nameResult = $stmt->execute();
    
                    if ($nameResult) {  // Check if the query execution was successful
                        $row = $nameResult->fetchArray(SQLITE3_ASSOC);
    
                        if ($row !== false) {
                            $name = $row['First_Name'];
                            $result[] = "<a href='Character.php?id=$id'>$name</a>";
                        } else {
                            $result[] = "Name not found for ID: $id";
                        }
                    }
                }
                }
                

            return implode(", ", $result);
        }


        echo "<table class='character-info'>";
        echo "<tr>";
        echo "<th>Eltern</th>";
        echo (!empty($row['Parent1'])) ? "<td>" . extractNames($row['Parent1'], $conn) . ", " . extractNames($row['Parent2'], $conn) . "</td>" : "<td>nicht bekannt</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Großelternteil</th>";
        echo (!empty($row['Grandparent1'])) ? "<td>" . extractNames($row['Grandparent1'], $conn) . ", " . extractNames($row['Grandparent2'], $conn) . "</td>" : "<td>nicht bekannt</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Partner</th>";
        echo (!empty($row['Partner'])) ? "<td>" . extractNames($row['Partner'], $conn) . "</td>" : "<td>-</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Geschwister</th>";
        echo (!empty($row['Sibling'])) ? "<td>" . extractNames($row['Sibling'], $conn) . "</td>" : "<td>-</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Tanten</th>";
        echo (!empty($row['Aunt'])) ? "<td>" . extractNames($row['Aunt'], $conn) . "</td>" : "<td>-</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Onkel</th>";
        echo (!empty($row['Uncle'])) ? "<td>" . extractNames($row['Uncle'], $conn) . "</td>" : "<td>-</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Kinder</th>";
        echo (!empty($row['Child'])) ? "<td>" . extractNames($row['Child'], $conn) . "</td>" : "<td>-</td>";
        echo "</tr>";
        echo "</table>";
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
                $row["Describtion"]
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
