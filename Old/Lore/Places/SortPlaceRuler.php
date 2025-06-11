<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");

$conn = DBConnection::getConnection();

$id = $_GET['id'];

if (isset($id)) {
    $sql = "SELECT * FROM lore_place WHERE place_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $event = new LorePlace(
            $row["place_id"],
            $row["Region_id"],
            $row["Name"],
            $row["Description"]
        );
    }

    $output = getAllCharacters();
}

if (isset($_POST['connect'])) {
    $char = $_POST['Race'];

    $sql = "INSERT INTO sort_place_ruler (Place_id, Character_id) VALUES (:id, :race_id)";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id',$id);
    $stmt->bindValue(':race_id',$char);
    $result = $stmt->execute();

    if (!$result) {
        echo "Error" . $conn->lastErrorMsg();
    } else {
        header("Location: Place.php?id=".$id);
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
            <form action="SortPlaceRuler.php?id=<?php echo $id ?>" method="post">
                <label for="event">Ort Herrscher:</label>
                <input type="text" name="event" id="event" readonly value="<?php echo $event->getName() ?>">
                <select name="Race" id="Race" style="color: black;">
                    <?php foreach ($output as $o) {
                        echo "<option value='" . $o->getID() . "'>" . $o->getFirstName() . " ". $o->getLastName() . "</option>";
                    } ?>
                </select>
                <input type="submit" value="Verbindung erschaffen" name="connect">
            </form>
        </div>
    </div>


</body>

</html>