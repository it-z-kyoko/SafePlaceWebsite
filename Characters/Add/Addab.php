<?php
    session_start();
    include_once("../../Classes/DBConnection.php");

    $conn = DBConnection::getConnection();

    $searching = $_GET['id'];

    $abilities = array(); // Initialize the $abilities array outside the if condition

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

    // Abfrage der Fähigkeiten für den Charakter
    $sql_abilities = "SELECT * FROM character_ability WHERE character_id = ?";
    $stmt_abilities = $conn->prepare($sql_abilities);
    $stmt_abilities->bindValue(1, $searching, SQLITE3_INTEGER);
    $result_abilities = $stmt_abilities->execute();

    if ($result_abilities) {
        while ($row = $result_abilities->fetchArray(SQLITE3_ASSOC)) {
            $abilities[] = $row['Describtion'];
        }
    } else {
        // Handle the error, for example:
        echo "Error querying abilities: " . $conn->lastErrorMsg();
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
        <div class="container">
            <form action="<?php echo 'Addab.php?id=' . $_GET['id'] ?>" method="POST">
                <label>Fähigkeiten:</label>
                <input type="text" name="new-ability" placeholder="Neue Fähigkeit">
                <input type="submit" name="add" value="Feld hinzufügen">
                <input type="button" class="noticemebutton" value="Fertig" onclick="location.href = '../Character.php?id=<?php echo htmlspecialchars($searching); ?>'">
            </form>
        </div>
        <div class="abilities-list">
        <h3>Aktuelle Fähigkeiten:</h3>
        <ul>
            <?php foreach ($abilities as $ability): ?>
                <li><?php echo $ability; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    </div>
</body>

</html>


<style>
    body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    flex-direction: column;
}

.flex {
    display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
    flex-wrap: wrap;
    align-items: center;
    width: 80%;
    backdrop-filter: blur(10px);
    background: rgb(0 0 0 / 49%);
    border-radius: 65px;
}
</style>