<?php
include_once("../../Classes/DBConnection.php");
$searching = $_GET['id'];

// Datenbankverbindung herstellen
$conn = DBConnection::getConnection();
$ca = DBConnection::SelectCharacterbyCharacterid($searching);

$sql = "SELECT * FROM character_family_role WHERE character_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $searching, SQLITE3_INTEGER);
$result = $stmt->execute();

if ($result) {
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $SelectList[] = $row['Role'];
    }
}

$sql = "SELECT character_id as id, First_Name as name FROM character order by name";
$stmt = $conn->prepare($sql);
$result = $stmt->execute();

$output = array();
if ($result->numColumns() > 0) {
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $output[] = array("id" => $row['id'], "name" => $row['name']);
    }
}

if (isset($_POST['save'])) {
    $conid = $_POST['Character'];
    $Role = $_POST['Role'];

    $sql = "INSERT INTO character_family_role (character_id,Connected_Character,Role) VALUES (:character_id,:Connected,:Role);";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':character_id', $searching);
    $stmt->bindValue('Connected', $conid);
    $stmt->bindValue('Role', $Role);
    $result = $stmt->execute();

    if (!$result) {
        echo "Error" . $conn->lastErrorMsg();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familie Bearbeiten</title>
    <link rel="stylesheet" href="../Characters.css">
    <link rel="stylesheet" href="Edit.css">
</head>

<body>
    <div class="div-2">
        <div class="background-image"></div>
        <?php include("../../GlobalResources/Navbar.php") ?>
        <?php include_once("../../GlobalResources/Search.php"); ?>
        <h1><?php echo ($ca->getFirstName() . " " . $ca->getLastName()) ?></h1>
        <div class="flex">
            <form action="EditFamily2.php?id=<?php echo $searching?>" method="post">
                <label for="Charakter">Charakter</label>
                <select name="Character" id="Character" style="color: black;">
                    <?php foreach ($output as $o) {
                        echo "<option value='" . $o['id'] . "'>" . $o['name'] . "</option>";
                    } ?>
                </select>
                <label for="Role">Rolle</label>
                <select name="Role" id="Role" style="color: black;">
                    <option value="Child">Kind</option>
                    <option value="Parent">Elternteil</option>
                    <option value="Sibling">Geschwister</option>
                </select>
                <input type="submit" value="Speichern" name="save">
            </form>
        </div>
        <div class="spacer">
            <input type="hidden" name="">
        </div>
    </div>
</body>

</html>

<style>
    .spacer {
        height: 1100px;
    }
</style>