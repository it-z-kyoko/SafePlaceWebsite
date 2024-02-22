<?php
session_start();
include_once("../../Classes/DBConnection.php");

$id = $_GET['id'];

$character = DBConnection::SelectCharacterbyCharacterid($id);

if (isset($_POST["update2"])) {
    // Prüfe, ob der GET-Parameter "id" gesetzt ist
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $Alter = $_POST["age"];
        $Volk = $_POST["race"];
        $Geburtstag = $_POST["birthday"];
        $Geschlecht = $_POST["gender"];
        $Größe = $_POST["height"];
        $Gewicht = $_POST["weight"];
        $nickname = $_POST["nickname"];

        include_once("../../Classes/DBConnection.php");
        $conn = DBConnection::getConnection();

        // Überprüfe, ob Datensatz existiert
        $check_sql = "SELECT * FROM `character_profiles` WHERE `characters_id` = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindValue(1, $id, SQLITE3_INTEGER);
        $stmtres = $check_stmt->execute();
        $result = $stmtres->fetchArray(SQLITE3_ASSOC);

        if (!$result) {
            // Datensatz existiert nicht, führe ein INSERT aus
            $insert_sql = "INSERT INTO `character_profiles` (`characters_id`, `Nickname`, `Age`, `Race`, `Birthday`, `Gender`, `Height`, `Weight`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bindValue(1, $id, SQLITE3_INTEGER);
            $insert_stmt->bindValue(2, $nickname, SQLITE3_TEXT);
            $insert_stmt->bindValue(3, $Alter, SQLITE3_INTEGER);
            $insert_stmt->bindValue(4, $Volk, SQLITE3_TEXT);
            $insert_stmt->bindValue(5, $Geburtstag, SQLITE3_TEXT);
            $insert_stmt->bindValue(6, $Geschlecht, SQLITE3_TEXT);
            $insert_stmt->bindValue(7, $Größe, SQLITE3_TEXT);
            $insert_stmt->bindValue(8, $Gewicht, SQLITE3_TEXT);

            if ($insert_stmt->execute()) {
                $insert_stmt->close();
                $conn->close();
                header("Location: ../Character.php?id=" . $id);
                exit();
            } else {
                echo "Error inserting data: " . $conn->lastErrorMsg();
            }
        } else {
            // Datensatz existiert, führe ein UPDATE aus
            $update_sql = "UPDATE `character_profiles` SET `Nickname`=?,`Age`=?,`Race`=?,`Birthday`=?,`Gender`=?,`Height`=?,`Weight`=? WHERE `characters_id` = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bindValue(1, $nickname, SQLITE3_TEXT);
            $update_stmt->bindValue(2, $Alter, SQLITE3_INTEGER);
            $update_stmt->bindValue(3, $Volk, SQLITE3_TEXT);
            $update_stmt->bindValue(4, $Geburtstag, SQLITE3_TEXT);
            $update_stmt->bindValue(5, $Geschlecht, SQLITE3_TEXT);
            $update_stmt->bindValue(6, $Größe, SQLITE3_TEXT);
            $update_stmt->bindValue(7, $Gewicht, SQLITE3_TEXT);
            $update_stmt->bindValue(8, $id, SQLITE3_INTEGER);

            if ($update_stmt->execute()) {
                $update_stmt->close();
                $conn->close();
                header("Location: ../Character.php?id=" . $id);
                exit();
            } else {
                echo "Error updating data: " . $conn->lastErrorMsg();
            }
        }
        $check_stmt->close();
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bearbeiten</title>
    <link rel="stylesheet" href="../Characters.css">
    <link rel="stylesheet" href="Edit.css">
</head>

<body>
    <div class="background-image"></div>
    <?php include("../../GlobalResources/Navbar.php") ?>
    <div class="flex">
        <form action="<?php echo 'EditInfo.php?id=' . $_GET['id'] ?>" method="POST">
            <label for="nickname">Spitzname:</label>
            <input type="text" id="nickname" name="nickname" value="<?php echo $character->getNickname(); ?>">

            <label for="age">Alter:</label>
            <input type="number" id="age" name="age" value="<?php echo $character->getAge(); ?>">

            <label for="race">Volk:</label>
            <input type="text" id="race" name="race" value="<?php echo $character->getRace(); ?>">

            <label for="birthday">Geburtstag:</label>
            <input type="text" id="birthday" name="birthday" value="<?php echo $character->getBirthday(); ?>">

            <label for="gender">Geschlecht:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $character->getGender(); ?>">

            <label for="height">Größe:</label>
            <input type="number" id="height" name="height" value="<?php echo $character->getHeight(); ?>">

            <label for="weight">Gewicht:</label>
            <input type="number" id="weight" name="weight" value="<?php echo $character->getWeight(); ?>">

            <label for="child">Ist der Charakter ein Kind?</label>
            <input type="checkbox" name="child" id="child" <?php echo ($character->getChild() == 1) ? 'checked' : '' ?>>

            <input type="submit" name="update2" value="Edit">
        </form>
    </div>
</body>

</html>