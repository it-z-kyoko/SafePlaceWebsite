<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");

$conn = DBConnection::getConnection();

$id = $_GET['id'];

if (isset($id)) {
    $sql = "SELECT * FROM lore_event WHERE event_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $event = new Event($row['event_id'], $row['lore_id'], $row['Name'], $row['Short_Description'], $row['Description'], $row['Player_id']);
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
}

if (isset($_POST['connect'])) {
    $char = $_POST['Character'];

    $sql = "INSERT INTO sort_event_character (Event_id, Character_id) VALUES (:id, :character_id)";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id',$id);
    $stmt->bindValue(':character_id',$char);
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
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../Lore.css">
    <link rel="stylesheet" href="../../Characters/Characters.css">
    <link rel="stylesheet" href="../../Characters/Edit/Edit.css">
    <title>Zuordnen</title>
</head>

<body>
    <div class="background-image"></div>
    <div class="div-2">
        <?php include("../../GlobalResources/Navbar.php") ?>
        <div class="flex">
            <form action="SortEventCharacter.php?id=<?php echo $id ?>" method="post">
                <label for="event">Event:</label>
                <input type="text" name="event" id="event" readonly value="<?php echo $event->getName() ?>">
                <select name="Character" id="Character" style="color: black;">
                    <?php foreach ($output as $o) {
                        echo "<option value='" . $o['id'] . "'>" . $o['name'] . "</option>";
                    } ?>
                </select>
                <input type="submit" value="Verbindung erschaffen" name="connect">
            </form>
        </div>
    </div>


</body>

</html>