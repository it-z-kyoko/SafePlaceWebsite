<?php
include_once("../../Classes/DBConnection.php");

if (isset($_POST['voll'])) {
    $conn = DBConnection::getConnection();
    $fn = $_POST["Vorname"];
    $ln = $_POST["Nachname"];
    $p = date('Y-m-d', strtotime($_POST["Posted"]));
    $player = $_POST["Spieler"];


    switch ($player) {
        case 'Kyo':
            $pid = 1;
            break;
        case 'Anni':
            $pid = 3;
            break;
        case 'Lea':
            $pid = 2;
            break;
        default:
            $pid = null;
            break;
    }
    try {
        $conn->exec('BEGIN TRANSACTION');

        $sql = "INSERT INTO `character` (First_Name, Last_Name, Player_id, Posted) VALUES (?,?,?,?)";
        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $fn, SQLITE3_TEXT);
        $sql->bindValue(2, $ln, SQLITE3_TEXT);
        $sql->bindValue(3, $pid, SQLITE3_INTEGER);
        $sql->bindValue(4, $p, SQLITE3_TEXT);

        if ($sql->execute()) {
            $sql->close(); // Close the statement object
        } else {
            echo "Fehler beim Insert: " . $conn->lastErrorMsg();
        }

        $conn->exec('COMMIT');
    } catch (Exception $e) {
        $conn->exec('ROLLBACK');
        echo "Fehler beim Insert: " . $e->getMessage();
    }
}

if (isset($_POST['base'])) {
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Edit.css">
    <link rel="stylesheet" href="../Characters.css">
    <title>Erstelle einen Charakter</title>
</head>

<body>
    <div class="background-image"></div>
    <?php include("../../GlobalResources/Navbar.php") ?>
    <h1>Charakter Erstellen</h1>
    <div class="page-content">
        <form action="<?php echo 'CreateCharacter.php' ?>" method="POST">
            <label for="Vorname">Vorname:</label>
            <input type="text" name="Vorname" id="Vorname">
            <label for="Nachname">Nachname:</label>
            <input type="text" name="Nachname" id="Nachname">
            <label for="Posted">Geposted am: </label>
            <input type="date" name="Posted" id="Posted">
            <label for="Spieler">Spieler: </label>
            <input type="text" name="Spieler" id="Spieler">
            <input type="submit" value="Abschicken" name="voll">
        </form>
    </div>
</body>

</html>

<style type="text/css">
    .page-content {
        display: flex;
        width: 80%;
        backdrop-filter: blur(10px);
        background: rgb(0 0 0 / 49%);
        border-radius: 65px;
        padding-left: 100px;
        flex-direction: column;
        align-items: center;
        padding: 20px 0px 20px 0px;
        ;
    }

    form,
    label,
    input {
        width: 80%;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: start;
    }
</style>