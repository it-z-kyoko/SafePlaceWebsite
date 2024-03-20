<?php
include_once("../../Classes/DBConnection.php");
$conn = DBConnection::getConnection();

// Überprüfen, ob die Verbindung erfolgreich ist
if (!$conn) {
    die("Connection failed: " . $conn->lastErrorMsg());
}


// SQL-Abfrage
$sql = "SELECT `character_id`,`First_Name`,`Last_Name` FROM `character`";
$result = $conn->query($sql);
var_dump($result);

// Daten in ein assoziatives Array umwandeln
$data = array();
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $data[] = $row;
}

// Datenbankverbindung schließen
$conn->close();

// JSON-Ausgabe
header('Content-Type: application/json');
echo json_encode($data);
?>
