<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../Classes/Race.php");
include_once("../../GlobalResources/ToolTips.php");
$conn = DBConnection::getConnection();

$Lore = getallEvents();

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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event'], $_GET['id'])) {
    $id = $_GET['id'];
    $Name = $_POST['Name'];
    $Beschreibung = nl2br($_POST['Beschreibung']);
    $Personality = nl2br($_POST['Personality']);
    $Body_Description = nl2br($_POST['Body_Description']);
    $Relationships = nl2br($_POST['Relationships']);
    $Alignment = nl2br($_POST['Alignment']);
    $Land_Origin = nl2br($_POST['Land_Origin']);
    $Religion = nl2br($_POST['Religion']);
    $Language = nl2br($_POST['Language']);
    $Names = nl2br($_POST['Names']);
    $Player = $_POST['Player'];

    $sql = "UPDATE lore_race SET Name = :Name, Description = :Description, Personality = :Personality, 
            Body_Description = :Body_Description, Relationships = :Relationships, Alignment = :Alignment,
            Land_Origin = :Land_Origin, Religion = :Religion, Language = :Language, Names = :Names, player_id = :Player 
            WHERE race_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Description', $Beschreibung);
    $stmt->bindParam(':Personality', $Personality);
    $stmt->bindParam(':Body_Description', $Body_Description);
    $stmt->bindParam(':Relationships', $Relationships);
    $stmt->bindParam(':Alignment', $Alignment);
    $stmt->bindParam(':Land_Origin', $Land_Origin);
    $stmt->bindParam(':Religion', $Religion);
    $stmt->bindParam(':Language', $Language);
    $stmt->bindParam(':Names', $Names);
    $stmt->bindParam(':Player', $Player);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: RaceOverview.php'); // Stelle sicher, dass dies die richtige Weiterleitungsseite ist
        exit;
    } else {
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
            <h1>Bearbeite ein Volk</h1>
            <form action="EditRace.php?id=<?php echo $id ?>" method="post">
                <?php ToolTip("NameEvent", '<label for="Name">Name:</label>') ?>
                <input type="text" name="Name" id="Name" value="<?php echo $race->getName(); ?>">
                <?php ToolTip("Beschreibung", '<label for="Beschreibung">Beschreibung:</label>') ?>
                <textarea name="Beschreibung" id="Beschreibung"><?php echo $race->getDescription() ?></textarea>
                <?php ToolTip("Personality", '<label for="Personality">Persönlichkeit:</label>') ?>
                <textarea name="Personality" id="Personality"><?php echo $race->getPersonality() ?></textarea>
                <?php ToolTip("Body_Description", '<label for="Body_Description">Körper Beschreibung:</label>') ?>
                <textarea name="Body_Description" id="Body_Description"><?php echo $race->getBodyDescription() ?></textarea>
                <?php ToolTip("Race_Relationship", '<label for="Relationships">Beziehungen:</label>') ?>
                <textarea name="Relationships" id="Relationships"><?php echo $race->getRelationships() ?></textarea>
                <?php ToolTip("Alignment", '<label for="Alignment">Moralische Ausrichtung:</label>') ?>
                <textarea name="Alignment" id="Alignment"><?php echo $race->getAlignment() ?></textarea>
                <?php ToolTip("Land_Origin", '<label for="Alignment">Herkunft:</label>') ?>
                <textarea name="Land_Origin" id="Land_Origin"><?php echo $race->getLandOrigin() ?></textarea>
                <?php ToolTip("Religion", '<label for="Alignment">Religion:</label>') ?>
                <textarea name="Religion" id="Religion"><?php echo $race->getReligion() ?></textarea>
                <?php ToolTip("Language", '<label for="Alignment">Sprache:</label>') ?>
                <textarea name="Language" id="Language"><?php echo $race->getLanguage() ?></textarea>
                <?php ToolTip("Names", '<label for="Names">Gebräuchliche Namen:</label>') ?>
                <textarea name="Names" id="Names"><?php echo $race->getLanguage() ?></textarea>
                <?php ToolTip("Player", '<label for="Player">Zugehöriger Spieler:</label>') ?>
                <select name="Player" id="Player">
                    <?php
                    $players = [
                        1 => 'Kyo',
                        3 => 'Anni',
                        2 => 'Lea'
                    ];

                    foreach ($players as $value => $name) {
                        $selected = ($race->getPlayer() == $value) ? 'selected' : '';
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