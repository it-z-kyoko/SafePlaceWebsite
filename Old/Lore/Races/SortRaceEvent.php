<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../Classes/Race.php");


$conn = DBConnection::getConnection();

$id = $_GET['id'];

if (isset($id)) {
    $sql = "SELECT * FROM AllRaces WHERE RaceID = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $race = new Race(
            $row["RaceID"],
            $row["PlayerID"],
            $row["Name"],
            $row["Description"],
            $row["Personality"],
            $row["Body_Description"],
            $row["Relationships"],
            $row["Alignment"],
            $row["Land_Origin"],
            $row["Religion"],
            $row["Language"],
            $row["Names"]);
    }

    $sql = "SELECT event_id as id, Name as name FROM lore_event order by name";
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
    $char = $_POST['Event'];

    $sql = "INSERT INTO sort_race_event (Race_id,Event_id) VALUES (:id, :event_id)";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id',$id);
    $stmt->bindValue(':event_id',$char);
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
            <form action="SortRaceEvent.php?id=<?php echo $id ?>" method="post">
                <label for="race">Volk:</label>
                <input type="text" name="race" id="race" readonly value="<?php echo $race->getName() ?>">
                <select name="Event" id="Event" style="color: black;">
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