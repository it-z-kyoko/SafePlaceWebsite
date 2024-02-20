<?php
session_start();
include_once("../../Classes/DBConnection.php");

$conn = DBConnection::getConnection();

$searching = $_GET['id'];

if (isset($_POST['add'])) {
    $id = $searching;
    $description = $_POST['new-ability'];

    // Verwende vorbereitete Anweisungen, um SQL-Injection zu verhindern
    $sql = "INSERT INTO character_ability (character_id, Describtion) VALUES (?, ?)";

    $statement = $conn->prepare($sql);
    $statement->bindValue(1, $id, SQLITE3_INTEGER);
    $statement->bindValue(2, $description, SQLITE3_TEXT);

    $result = $statement->execute();

    if (!$result) {
        // Handle the error, for example:
        echo "Error: " . $conn->lastErrorMsg();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fähigkeiten hinzufügen</title>
    <link rel="stylesheet" href="Edit.css">
</head>
<body>
<div class="container">
    <form action="<?php echo 'AddAbilities.php?id=' . $_GET['id'] ?>" method="POST">
        <label>Fähigkeiten:</label>
        <input type="text" name="new-ability" placeholder="Neue Fähigkeit">
        <input type="submit" name="add" value="Feld hinzufügen">
        <input type="button" class="noticemebutton" value="Fertig" onclick="location.href = 'Edit.php?id=<?php echo htmlspecialchars($searching); ?>'">
    </form>
</div>
</body>
</html>
