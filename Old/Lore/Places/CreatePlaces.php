<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../GlobalResources/ToolTips.php");
$conn = DBConnection::getConnection();

$Region = getAllRegions();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['event'])) {
    $Name = $_POST['Name'];
    $Region = $_POST['Region'];
    $Description = nl2br($_POST['Description']);

    $sql = "INSERT INTO lore_place (Region_id, Name, Description) VALUES (:Region, :Name, :Description)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Region', $Region);
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Description', $Description);

    $result = $stmt->execute();

    if (!$result) {
        echo "Error: " . $conn->lastErrorMsg();
    } else {
        header("Location: PlacesOverview.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erstelle ein Lore-Event</title>
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../Lore.css">
    <link rel="stylesheet" href="../../Characters/Edit/Edit.css">
</head>

<body>
    <div class="background-image"></div>
    <div class="div-2">
        <?php include("../../GlobalResources/Navbar.php") ?>
        <div class="flex">
            <h1>Erstelle einen Ort</h1>
            <form action="CreatePlaces.php" method="post">
                <?php ToolTip("NamePlaces", '<label for="Name">Name:</label>') ?>
                <input type="text" name="Name" id="Name" required>
                <?php ToolTip("RegionID", '<label for="Region">Region:</label>') ?>
                <select name="Region" id="Region" style="color: black;" required>
                    <?php foreach ($Region as $r) {
                        echo "<option value='" . $r->getRegionId() . "'>" . htmlspecialchars($r->getName()) . "</option>";
                    } ?>
                </select>
                <?php ToolTip("Beschreibung", '<label for="Description">Beschreibung:</label>') ?>
                <textarea name="Description" id="Description" required></textarea>
                <input type="submit" value="Event Erstellen" name="event">
            </form>
        </div>
    </div>
</body>

</html>