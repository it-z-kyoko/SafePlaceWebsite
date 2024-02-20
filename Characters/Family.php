<?php
// Character ID aus der URL holen
$searching = $_GET['id'];

// Datenbankverbindung herstellen
$conn = DBConnection::getConnection();

// SQL-Abfrage für den gewünschten Datensatz
$sql = "SELECT * FROM character_family WHERE character_id = $searching";
$result = $conn->query($sql);

// Überprüfen, ob ein Datensatz gefunden wurde
if ($result->numColumns() > 0) {
    $row = $result->fetchArray(SQLITE3_ASSOC);

    // Funktion zum Extrahieren von Namen aus komma-separierten Listen
    function extractNames($list, $conn)
    {
        $names = explode(",", $list);
        $result = array();

        foreach ($names as $id) {
            // Namen aus der Characters-Tabelle abfragen
            $sql = "SELECT `First_Name` FROM characters WHERE character_id = $id";
            $nameResult = $conn->query($sql);

            if ($nameResult->numColumns() > 0) {
                $name = $nameResult->fetchArray(SQLITE3_ASSOC)['First_Name'];
                $result[] = "<a href='Character.php?id=$id'>$name</a>";
            }
        }

        return implode(", ", $result);
    }

    echo "<table class='character-info'>";
    echo "<tr>";
    echo "<th>Eltern</th>";
    echo (!empty($row['Parent1'])) ? "<td>" . extractNames($row['Parent1'], $conn) . ", " . extractNames($row['Parent2'], $conn) . "</td>" : "<td>-</td>";
    echo "<tr>";
    echo "<tr>";
    echo "<th>Großelternteil</th>";
    echo (!empty($row['Grandparent1'])) ? "<td>" . extractNames($row['Grandparent1'], $conn) . ", " . extractNames($row['Grandparent2'], $conn) . "</td>" : "<td>-</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<th>Partner</th>";
    echo (!empty($row['Partner'])) ? "<td>" . extractNames($row['Partner'], $conn) . "</td>" : "<td>-</td>";
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
?>
