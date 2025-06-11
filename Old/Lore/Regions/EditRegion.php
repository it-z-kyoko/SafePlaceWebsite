<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../Classes/Region.php");  // Stellen Sie sicher, dass diese Klasse existiert und korrekt ist
include_once("../../GlobalResources/ToolTips.php");
$conn = DBConnection::getConnection();

$id = $_GET['id'];

if (isset($id)) {
    $sql = "SELECT * FROM lore_region WHERE region_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $result= $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row) {
        $place = new LoreRegion($row['region_id'], $row['Name'],$row['Description'], $row['Player_id']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['event'])) {
    $Name = $_POST['Name'];
    $Description = nl2br($_POST['Description']);
    $Player_id = $_POST['Player'];

    $sql = "UPDATE lore_region SET Name = :Name, Description = :Description, Player_id = :Player WHERE region_id = :region_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Description', $Description);
    $stmt->bindParam(':Player', $Player_id);
    $stmt->bindParam(':region_id', $id);
    if ($stmt->execute()) {
        header('Location: RegionOverview.php');
    } else {
        echo "Error updating record: " . $conn->lastErrorMsg();
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
            <form action="EditRegion.php?id=<?php echo $id ?>" method="post">
                <?php ToolTip("NamePlaces", '<label for="Name">Name:</label>') ?>
                <input type="text" name="Name" id="Name" value="<?php echo htmlspecialchars($place->getName()); ?>" required>
                <?php ToolTip("Beschreibung", '<label for="Description">Beschreibung:</label>') ?>
                <textarea name="Description" id="Description" required><?php echo htmlspecialchars($place->getDescription()); ?></textarea>
                <?php ToolTip("Player", '<label for="Player">Zugehöriger Spieler:</label>') ?>
                <select name="Player" id="Player">
                    <?php
                    $players = [
                        1 => 'Kyo',
                        3 => 'Anni',
                        2 => 'Lea'
                    ];

                    foreach ($players as $value => $name) {
                        $selected = ($place->getPlayerId() == $value) ? 'selected' : '';
                        echo "<option value='$value' $selected>$name</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Änderungen speichern" name="event">
            </form>
        </div>
    </div>
</body>
</html>
