<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../Classes/Event.php");
include_once("../../GlobalResources/ToolTips.php");
$conn = DBConnection::getConnection();

$Lore = getallEvents();

$id = $_GET['id'];

if (isset($id)) {
    $sql = "SELECT * FROM lore_event WHERE event_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $event = new Event($row['event_id'], $row['lore_id'], $row['Name'], $row['Short_Description'], $row['Description'], $row['Player_id']);
    }
}

if (isset($_POST['event'])) {
    $Name = $_POST['Name'];
    $Lore = $_POST['Lore'];
    $Kurzbeschreibung = nl2br($_POST['Kurzbeschreibung']);
    $Beschreibung = nl2br($_POST['Beschreibung']);
    $Player = $_POST['Player'];

    $sql = "UPDATE lore_event SET Name = :Name, Short_Description = :Short_Description, Description = :Description, Player_id = :Player WHERE event_id = :event_id";

    $stmt = $conn->prepare($sql);

    // Parameter binden
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Short_Description', $Kurzbeschreibung);
    $stmt->bindParam(':Description', $Beschreibung);
    $stmt->bindParam(':Player', $Player);
    $stmt->bindParam(':event_id', $id);

    // Ausführung des Statements
    $result = $stmt->execute();

    // Überprüfen auf Fehler
    if (!$result) {
        echo "Error: " . $conn->lastErrorMsg();
    }

    header('location: EventOverview.php');
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
            <form action="EditEvents.php?id=<?php echo $id ?>" method="post">
                <?php ToolTip("NameEvent", '<label for="Name">Name:</label>') ?>
                <input type="text" name="Name" id="Name" value="<?php echo $event->getName(); ?>">
                <?php ToolTip("LoreID", '<label for="Lore">Lore:</label>') ?>
                <select name="Lore" id="Lore" style="color: black;">
                    <?php
                    foreach ($Lore as $l) {
                        $id = $l->getId();
                        $name = $l->getName();
                        $selected = ($event->getLoreId() == $id) ? 'selected' : '';
                        echo "<option value='$id' $selected>$name</option>";
                    }
                    ?>
                </select>

                <?php ToolTip("Kurzbeschreibung_Event", '<label for="Kurzbeschreibung">Kurzbeschreibung:</label>') ?>
                <textarea name="Kurzbeschreibung" id="Kurzbeschreibung"><?php echo $event->getShortDescription() ?></textarea>
                <?php ToolTip("Beschreibung", '<label for="Beschreibung">Beschreibung:</label>') ?>
                <textarea name="Beschreibung" id="Beschreibung"><?php echo $event->getDescription() ?></textarea>
                <?php ToolTip("Player", '<label for="Player">Zugehöriger Spieler:</label>') ?>
                <select name="Player" id="Player">
                    <?php
                    $players = [
                        1 => 'Kyo',
                        3 => 'Anni',
                        2 => 'Lea'
                    ];

                    foreach ($players as $value => $name) {
                        $selected = ($event->getPlayer() == $value) ? 'selected' : '';
                        echo "<option value='$value' $selected>$name</option>";
                    }
                    ?>
                </select>

                <input type="submit" value="Event Bearbeiten" name="event">
            </form>
            <div class="spacer">
                <input type="hidden" name="">
            </div>
        </div>
    </div>

</body>

</html>