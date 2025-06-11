<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../Classes/Place.php");  // Stellen Sie sicher, dass diese Klasse existiert und korrekt ist
include_once("../../GlobalResources/ToolTips.php");
$conn = DBConnection::getConnection();

$Regions = getAllRegions();  // Diese Funktion sollte alle verfügbaren Regionen liefern

$id = $_GET['id'];

if (isset($id)) {
    $sql = "SELECT * FROM lore_place WHERE place_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $result= $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row) {
        $place = new LorePlace($row['place_id'], $row['Region_id'],$row['Name'], $row['Description']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['event'])) {
    $Name = $_POST['Name'];
    $Region = $_POST['Region'];
    $Description = nl2br($_POST['Description']);

    $sql = "UPDATE lore_place SET Name = :Name, Description = :Description, Region_id = :Region WHERE place_id = :place_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Description', $Description);
    $stmt->bindParam(':Region', $Region);
    $stmt->bindParam(':place_id', $id);
    $result = $stmt->execute();

    if (!$result) {
        echo "Error: " . $conn->lastErrorMsg();
    } else {
        header('Location: PlacesOverview.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lore Place</title>
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../Lore.css">
    <link rel="stylesheet" href="../../Characters/Edit/Edit.css">
</head>
<body>
    <div class="background-image"></div>
    <div class="div-2">
        <?php include("../../GlobalResources/Navbar.php"); ?>
        <div class="flex">
            <h1>Ort bearbeiten</h1>
            <form action="EditPlaces.php?id=<?php echo $id ?>" method="post">
                <?php ToolTip("NamePlaces", '<label for="Name">Name:</label>') ?>
                <input type="text" name="Name" id="Name" value="<?php echo htmlspecialchars($place->getName()); ?>" required>
                <?php ToolTip("RegionID", '<label for="Region">Region:</label>') ?>
                <select name="Region" id="Region" required>
                    <?php foreach ($Regions as $r) {
                        $selected = ($place->getRegionId() == $r->getRegionId()) ? 'selected' : '';
                        echo "<option value='" . $r->getRegionId() . "' $selected>" . htmlspecialchars($r->getName()) . "</option>";
                    } ?>
                </select>
                <?php ToolTip("Beschreibung", '<label for="Description">Beschreibung:</label>') ?>
                <textarea name="Description" id="Description" required><?php echo htmlspecialchars($place->getDescription()); ?></textarea>
                <input type="submit" value="Änderungen speichern" name="event">
            </form>
        </div>
    </div>
</body>
</html>
