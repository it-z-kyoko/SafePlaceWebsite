<?php 
include_once("../../Classes/DBConnection.php");
$searching = $_GET['id'];

// Datenbankverbindung herstellen
$conn = DBConnection::getConnection();
$ca = DBConnection::SelectCharacterbyCharacterid($searching);

// SQL-Abfrage für den gewünschten Datensatz
$sql = "SELECT * FROM character_family WHERE character_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $searching, SQLITE3_INTEGER);
$result = $stmt->execute();

// Überprüfen, ob ein Datensatz gefunden wurde
if ($result) {
    $row = $result->fetchArray(SQLITE3_ASSOC);
}

if (isset($_POST["update5"])) {
    $id = $_GET["id"];
    $E1 = $_POST["Elternteil1"];
    $E2 = $_POST["Elternteil2"];
    $Sib = $_POST["Geschwister"];
    $Kid = $_POST["Kinder"];
    $Tante = $_POST["Tante"];
    $Unc = $_POST["Onkel"];
    $Ge1 = $_POST["GroßElternteil1"];
    $Ge2 = $_POST["GroßElternteil2"];
    $Ge3 = $_POST["GroßElternteil3"];
    $Ge4 = $_POST["GroßElternteil4"];
    $Part = $_POST['Partner'];
    $Married = isset($_POST["Married"]) ? 1 : 0;

    // Überprüfen und leere Werte auf NULL setzen
    $E1 = empty($E1) ? null : $E1;
    $E2 = empty($E2) ? null : $E2;
    $Sib = empty($Sib) ? '' : $Sib;
    $Kid = empty($Kid) ? '' : $Kid;
    $Tante = empty($Tante) ? '' : $Tante;
    $Unc = empty($Unc) ? '' : $Unc;
    $Ge1 = empty($Ge1) ? null : $Ge1;
    $Ge2 = empty($Ge2) ? null : $Ge2;
    $Ge3 = empty($Ge3) ? null : $Ge3;
    $Ge4 = empty($Ge4) ? null : $Ge4;
    $Part = empty($Part) ? null : $Part;

    // Überprüfen, ob ein Datensatz bereits existiert
    $checkSql = "SELECT * FROM `character_family` WHERE `character_id` = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindValue(1, $id, SQLITE3_INTEGER);
    $result = $checkStmt->execute();
    $checkResult = $result->fetchArray(SQLITE3_ASSOC);

    if ($checkResult) {
        // Update durchführen
        $updateSql = "UPDATE `character_family` SET 
            `Parent1`=?,
            `Parent2`=?,
            `Grandparent1`=?,
            `Grandparent2`=?,
            `Grandparent3`=?,
            `Grandparent4`=?,
            `Sibling`=?,
            `Aunt`=?,
            `Uncle`=?,
            `Child`=?,
            `Partner`=?,
            `Married`=?
            WHERE `character_id`=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindValue(1, $E1, SQLITE3_INTEGER);
        $updateStmt->bindValue(2, $E2, SQLITE3_INTEGER);
        $updateStmt->bindValue(3, $Ge1, SQLITE3_INTEGER);
        $updateStmt->bindValue(4, $Ge2, SQLITE3_INTEGER);
        $updateStmt->bindValue(5, $Ge3, SQLITE3_INTEGER);
        $updateStmt->bindValue(6, $Ge4, SQLITE3_INTEGER);
        $updateStmt->bindValue(7, $Sib, SQLITE3_TEXT);
        $updateStmt->bindValue(8, $Tante, SQLITE3_TEXT);
        $updateStmt->bindValue(9, $Unc, SQLITE3_TEXT);
        $updateStmt->bindValue(10, $Kid, SQLITE3_TEXT);
        $updateStmt->bindValue(11, $Part, SQLITE3_TEXT);
        $updateStmt->bindValue(12, $Married, SQLITE3_INTEGER);
        $updateStmt->bindValue(13, $id, SQLITE3_INTEGER);

        $result = $updateStmt->execute();

        if ($result) {
            // Update erfolgreich
            $updateStmt->close();
        } else {
            // Fehler beim Update
            echo "Fehler beim Update: " . $conn->lastErrorMsg();
        }
    } else {
        // Datensatz existiert nicht, füge einen neuen Datensatz ein
        $insertSql = "INSERT INTO `character_family` (`character_id`, `Parent1`, `Parent2`, `Grandparent1`, `Grandparent2`, `Sibling`, `Aunt`, `Uncle`, `Child`, `Partner`, `Married`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bindValue(1, $id, SQLITE3_INTEGER);
        $insertStmt->bindValue(2, $E1, SQLITE3_INTEGER);
        $insertStmt->bindValue(3, $E2, SQLITE3_INTEGER);
        $insertStmt->bindValue(4, $Ge1, SQLITE3_INTEGER);
        $insertStmt->bindValue(5, $Ge2, SQLITE3_INTEGER);
        $insertStmt->bindValue(6, $Sib, SQLITE3_TEXT);
        $insertStmt->bindValue(7, $Tante, SQLITE3_TEXT);
        $insertStmt->bindValue(8, $Unc, SQLITE3_TEXT);
        $insertStmt->bindValue(9, $Kid, SQLITE3_TEXT);
        $insertStmt->bindValue(10, $Part, SQLITE3_TEXT);
        $insertStmt->bindValue(11, $Married, SQLITE3_INTEGER);

        $result = $insertStmt->execute();

        if ($result) {
            // Neuer Datensatz erfolgreich eingefügt
            $insertStmt->close();
        } else {
            // Fehler beim Einfügen
            echo "Fehler beim Einfügen: " . $conn->lastErrorMsg();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bearbeiten</title>
    <link rel="stylesheet" href="../Characters.css">
    <link rel="stylesheet" href="Edit.css">
</head>
<body>
<div class="background-image"></div>
    <?php include("../../GlobalResources/Navbar.php") ?>
<?php include_once("../../GlobalResources/Search.php"); ?>
    <h1><?php echo ($ca->getFirstName() . " " . $ca->getLastName()) ?></h1>
    <div class="flex">
        <form action="<?php echo 'Edit.php?id=' . $_GET['id'] ?>" method="POST">
            <label for="Elternteil1">Elternteil 1:</label>
            <input type="text" id="Elternteil1" name="Elternteil1" value="<?php echo !empty($row['Parent1']) ? $row['Parent1'] : ''; ?>">

            <label for="Elternteil2">Elternteil 2:</label>
            <input type="text" id="Elternteil2" name="Elternteil2" value="<?php echo !empty($row['Parent2']) ? $row['Parent2'] : ''; ?>">

            <label for="Geschwister">Geschwister:</label>
            <input type="text" id="Geschwister" name="Geschwister" value="<?php echo !empty($row['Sibling']) ? $row['Sibling'] : ''; ?>">

            <label for="Kinder">Kinder:</label>
            <input type="text" id="Kinder" name="Kinder" value="<?php echo !empty($row['Child']) ? $row['Child'] : ''; ?>">

            <label for="Tante">Tanten:</label>
            <input type="text" id="Tante" name="Tante" value="<?php echo !empty($row['Aunt']) ? $row['Aunt'] : ''; ?>">

            <label for="Onkel">Onkel:</label>
            <input type="text" id="Onkel" name="Onkel" value="<?php echo !empty($row['Uncle']) ? $row['Uncle'] : ''; ?>">

            <label for="GroßElternteil1">Großelternteil 1:</label>
            <input type="text" id="GroßElternteil1" name="GroßElternteil1" value="<?php echo !empty($row['Grandparent1']) ? $row['Grandparent1'] : ''; ?>">

            <label for="GroßElternteil2">Großelternteil 2:</label>
            <input type="text" id="GroßElternteil2" name="GroßElternteil2" value="<?php echo !empty($row['Grandparent2']) ? $row['Grandparent2'] : ''; ?>">

            <label for="GroßElternteil3">Großelternteil 3:</label>
            <input type="text" id="GroßElternteil3" name="GroßElternteil3" value="<?php echo !empty($row['Grandparent3']) ? $row['Grandparent3'] : ''; ?>">

            <label for="GroßElternteil4">Großelternteil 4:</label>
            <input type="text" id="GroßElternteil4" name="GroßElternteil4" value="<?php echo !empty($row['Grandparent4']) ? $row['Grandparent4'] : ''; ?>">

            <label for="Partner">Partner:</label>
            <input type="text" id="Partner" name="Partner" value="<?php echo !empty($row['Partner']) ? $row['Partner'] : ''; ?>">

            <label for="Married">Verheiratet:</label>
            <input type="checkbox" id="Married" name="Married" <?php echo !empty($row['Married']) ? 'checked' : ''; ?>>

            <input type="submit" name="update5" value="Edit">
        </form>
    </div>
</body>
</html>