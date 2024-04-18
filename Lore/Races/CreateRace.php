<?php
include_once("../../GlobalResources/SQLStuffis.php");
include_once("../../Classes/DBConnection.php");
include_once("../../Classes/Race.php");
include_once("../../GlobalResources/ToolTips.php");
$conn = DBConnection::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_event'])) {
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

    $sql = "INSERT INTO lore_race (Name, Description, Personality, Body_Description, Relationships, Alignment, 
            Land_Origin, Religion, Language, Names, player_id) VALUES (:Name, :Description, :Personality, 
            :Body_Description, :Relationships, :Alignment, :Land_Origin, :Religion, :Language, :Names, :Player)";

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

    if ($stmt->execute()) {
        header('Location: RaceOverview.php'); // Redirect to the race overview page
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
    <title>Erstelle ein Lore-Volk</title>
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../Lore.css">
    <link rel="stylesheet" href="../../Characters/Edit/Edit.css">
</head>
<body>
    <div class="background-image"></div>
    <div class="div-2">
        <?php include("../../GlobalResources/Navbar.php") ?>
        <div class="flex">
            <h1>Erstelle ein neues Volk</h1>
            <form action="" method="post">
                <?php ToolTip("NameEvent", '<label for="Name">Name:</label>') ?>
                <input type="text" name="Name" id="Name">
                <?php ToolTip("Beschreibung", '<label for="Beschreibung">Beschreibung:</label>') ?>
                <textarea name="Beschreibung" id="Beschreibung"></textarea>
                <?php ToolTip("Personality", '<label for="Personality">Persönlichkeit:</label>') ?>
                <textarea name="Personality" id="Personality"></textarea>
                <?php ToolTip("Body_Description", '<label for="Body_Description">Körper Beschreibung:</label>') ?>
                <textarea name="Body_Description" id="Body_Description"></textarea>
                <?php ToolTip("Race_Relationship", '<label for="Relationships">Beziehungen:</label>') ?>
                <textarea name="Relationships" id="Relationships"></textarea>
                <?php ToolTip("Alignment", '<label for="Alignment">Moralische Ausrichtung:</label>') ?>
                <textarea name="Alignment" id="Alignment"></textarea>
                <?php ToolTip("Land_Origin", '<label for="Land_Origin">Herkunft:</label>') ?>
                <textarea name="Land_Origin" id="Land_Origin"></textarea>
                <?php ToolTip("Religion", '<label for="Religion">Religion:</label>') ?>
                <textarea name="Religion" id="Religion"></textarea>
                <?php ToolTip("Language", '<label for="Language">Sprache:</label>') ?>
                <textarea name="Language" id="Language"></textarea>
                <?php ToolTip("Names", '<label for="Names">Gebräuchliche Namen:</label>') ?>
                <textarea name="Names" id="Names"></textarea>
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

                <input type="submit" value="Volk Erstellen" name="create_event">
            </form>
            <div class="spacer">
                <input type="hidden" name="">
            </div>
        </div>
    </div>

</body>
</html>
