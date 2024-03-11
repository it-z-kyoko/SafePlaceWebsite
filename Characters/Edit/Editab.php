<?php
session_start();
include_once("../../Classes/DBConnection.php");
include_once("../../Classes/Abilities.php");

$conn = DBConnection::getConnection();

$searching = $_GET['id'];

$abilities = array();

$sql_abilities = "SELECT * FROM character_ability WHERE character_id = ?";
$stmt_abilities = $conn->prepare($sql_abilities);
$stmt_abilities->bindValue(1, $searching, SQLITE3_INTEGER);
$result_abilities = $stmt_abilities->execute();

if ($result_abilities) {
    while ($row = $result_abilities->fetchArray(SQLITE3_ASSOC)) {
        $abilities[] = new Abilities($row['id'], $row['Describtion']);
    }
} else {
    // Handle the error, for example:
    echo "Error querying abilities: " . $conn->lastErrorMsg();
}

if (isset($_POST['update4'])) {
    // Aktualisiere vorhandene Fähigkeiten
    foreach ($_POST['ability'] as $id => $description) {
        // Escape für die Sicherheit, verwenden Sie in der Produktion vorbereitete Anweisungen
        $escaped_description = $conn->escapeString($description);

        // Aktualisiere die Fähigkeit basierend auf der ID
        $sql_update = "UPDATE character_ability SET Describtion = '$escaped_description' WHERE id = $id";
        $conn->query($sql_update);
    }
    header('Location: ../Character.php?id=' . $searching);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fähigkeiten hinzufügen</title>
    <link rel="stylesheet" href="../Characters.css">
</head>

<body>
    <div class="background-image"></div>
    <?php include("../../GlobalResources/Navbar.php") ?>
    <div class="flex">
        <form action="Editab.php?id=<?php echo htmlspecialchars($_GET['id']); ?>" method="POST">
            <label>Fähigkeiten:</label>
            <input type="button" class="noticemebutton" value="Neue Fähigkeit?" onclick="location.href = '../Add/Addab.php?id=<?php echo htmlspecialchars($searching); ?>'">
            <?php
            $i = 0;
            foreach ($abilities as $description) {
                $i += 1 ?>
                <textarea class="inputAbilities" type="text" name="ability[<?php echo $description->getId(); ?>]"><?php echo $description->getDescription(); ?></textarea>
                <br>
            <?php } ?>
            <input type="submit" name="update4" value="Fähigkeiten aktualisieren">
        </form>
    </div>
</body>

</html>


<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        flex-direction: column;
    }

    .flex {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 20px;
        width: 80%;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-direction: column;
        overflow-y: scroll;
        max-height: 800px;
    }

    form {
        display: flex;
        flex-direction: column;
        width: 80%;
        align-items: stretch;
        justify-content: center;
    }

    label {
        font-weight: bold;
        margin-top: 10px;
    }

    input,
    textarea {
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #ffffff;
        font-family: inherit;
        font-size: inherit;
    }

    input[type="submit"] {
        background-color: #003c8b;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        margin-top: 10px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0057c9;
    }
</style>