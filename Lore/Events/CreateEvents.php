<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../GlobalResources/ToolTips.php");
$conn = DBConnection::getConnection();

$Lore = getallEvents();

if (isset($_POST['event'])) {
    $Name = $_POST['Name'];
    $Lore = $_POST['Lore'];
    nl2br($Kurzbeschreibung = $_POST['Kurzbeschreibung']);
    nl2br($Beschreibung = $_POST['Beschreibung']);
    $Player = $_POST['Player'];

    $sql = "INSERT INTO lore_event (lore_id,Name, Short_Description, Description, Player_id) VALUES (:lore_id, :Name, :Short_Description, :Description ,:Player)";


    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':lore_id', $Lore);
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Short_Description', $Kurzbeschreibung);
    $stmt->bindParam(':Description', $Beschreibung);
    $stmt->bindParam(':Player', $Player);

    $result = $stmt->execute();

    if (!$result) {
        echo "Error: " . $conn->lastErrorMsg();
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
            <h1>Erstelle ein Event</h1>
            <form action="CreateEvents.php" method="post">
                <?php ToolTip("NameEvent", '<label for="Name">Name:</label>') ?>
                <input type="text" name="Name" id="Name">
                <?php ToolTip("LoreID", '<label for="Lore">Lore:</label>') ?>
                <select name="Lore" id="Lore" style="color: black;">
                    <?php foreach ($Lore as $l) {
                        echo "<option value='" . $l->getId() . "'>" . $l->getName() . "</option>";
                    } ?>
                </select>
                <?php ToolTip("Kurzbeschreibung_Event", '<label for="Kurzbeschreibung">Kurzbeschreibung:</label>') ?>
                <textarea name="Kurzbeschreibung" id="Kurzbeschreibung"></textarea>
                <?php ToolTip("Beschreibung", '<label for="Beschreibung">Beschreibung:</label>') ?>
                <textarea name="Beschreibung" id="Beschreibung"></textarea>
                <?php ToolTip("Player", '<label for="Player">Zugehöriger Spieler:</label>') ?>
                <select name="Player" id="Player">
                    <option value="1">Kyo</option>
                    <option value="3">Anni</option>
                    <option value="2">Lea</option>
                </select>
                <input type="submit" value="Event Erstellen" name="event">
            </form>
            <div class="spacer">
                <input type="hidden" name="">
            </div>
        </div>
    </div>

</body>
</html>