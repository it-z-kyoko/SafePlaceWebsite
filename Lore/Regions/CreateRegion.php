<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../Classes/Region.php");
include_once("../../GlobalResources/ToolTips.php");
$conn = DBConnection::getConnection();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['insert'])) {
    $Name = $_POST['Name'];
    $Description = nl2br($_POST['Description']);
    $Player_id = $_POST['Player'];

    $sql = "INSERT INTO lore_region (Name, Description, Player_id) VALUES (:Name, :Description, :Player)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Description', $Description);
    $stmt->bindParam(':Player', $Player_id);
    if ($stmt->execute()) {
        header('Location: RegionOverview.php');
    } else {
        echo "Error inserting new record: " . $conn->lastErrorMsg();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Lore Region</title>
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../Lore.css">
    <link rel="stylesheet" href="../../Characters/Edit/Edit.css">
</head>
<body>
    <div class="background-image"></div>
    <div class="div-2">
        <?php include("../../GlobalResources/Navbar.php"); ?>
        <div class="flex">
            <h1>Neue Region hinzufügen</h1>
            <form action="CreateRegion.php" method="post">
                <?php ToolTip("NamePlaces", '<label for="Name">Name:</label>') ?>
                <input type="text" name="Name" id="Name" required>
                <?php ToolTip("Beschreibung", '<label for="Description">Beschreibung:</label>') ?>
                <textarea name="Description" id="Description" required></textarea>
                <?php ToolTip("Player", '<label for="Player">Zugehöriger Spieler:</label>') ?>
                <select name="Player" id="Player">
                    <?php
                    $players = [
                        1 => 'Kyo',
                        3 => 'Anni',
                        2 => 'Lea'
                    ];
                    foreach ($players as $value => $name) {
                        echo "<option value='$value'>$name</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Region hinzufügen" name="insert">
            </form>
        </div>
    </div>
</body>
</html>
