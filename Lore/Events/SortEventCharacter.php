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
}

$sql = "SELECT character_id as id, First_Name as name FROM character";
$stmt = $conn->prepare($sql);
$result = $stmt->execute();

$output = array();
if ($result->numColumns() > 0) {
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $output[] = array("id" => $row['id'], "name" => $row['name']);
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
    <title>Zuordnen</title>
</head>

<body>
    <div class="background-image"></div>
    <div class="div-2">
        <?php include("../../GlobalResources/Navbar.php") ?>
        <div class="flex">
            <form action="SortEventCharacter.php?id=<?php echo $id ?>" method="post">
                <label for="event">Event:</label>
                <input type="text" name="event" id="event" readonly value="<?php echo $event->getName()?>">
                <input type="hidden" name="eventid" value="<?php echo $event->getId() ?>">
            </form>
        </div>
    </div>


</body>

</html>