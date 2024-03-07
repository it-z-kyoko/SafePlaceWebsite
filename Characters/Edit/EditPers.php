<?php
session_start();
include_once("../../Classes/DBConnection.php");
$searching = $_GET['id'];
$character = DBConnection::SelectCharacterbyCharacterid($searching);

if (isset($_POST["update3"])) {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $Likes = $_POST["Likes"];
        $Dislikes = $_POST["Dislikes"];
        $Personality = $_POST["Personality"];
        $Background = $_POST["Background"];

        include_once("../../Classes/DBConnection.php");
        $conn = DBConnection::getConnection();

        $check_sql = "SELECT * FROM `character_personality` WHERE `character_id` = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindValue(1, $id, SQLITE3_INTEGER);
        $check_result = $check_stmt->execute();

        if ($check_result) {
            $result_row = $check_result->fetchArray(SQLITE3_ASSOC);
            if (!$result_row) {
                // No rows found, perform insert
                $insert_sql = "INSERT INTO `character_personality` (`character_id`, `Likes`, `Dislikes`, `Personality`, `Background`) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bindValue(1, $id, SQLITE3_INTEGER);
                $insert_stmt->bindValue(2, $Likes, SQLITE3_TEXT);
                $insert_stmt->bindValue(3, $Dislikes, SQLITE3_TEXT);
                $insert_stmt->bindValue(4, $Personality, SQLITE3_TEXT);
                $insert_stmt->bindValue(5, $Background, SQLITE3_TEXT);

                $insert_result = $insert_stmt->execute();

                if ($insert_result) {
                    $insert_stmt->close();
                    header("Location: ../Character.php?id=" . $id);
                    exit;
                } else {
                    echo "Error inserting data: " . $conn->lastErrorMsg();
                }
            } else {
                // Row found, perform update
                $update_sql = "UPDATE `character_personality` SET `Likes`=?, `Dislikes`=?, `Personality`=?, `Background`=? WHERE `character_id` = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bindValue(1, $Likes, SQLITE3_TEXT);
                $update_stmt->bindValue(2, $Dislikes, SQLITE3_TEXT);
                $update_stmt->bindValue(3, $Personality, SQLITE3_TEXT);
                $update_stmt->bindValue(4, $Background, SQLITE3_TEXT);
                $update_stmt->bindValue(5, $id, SQLITE3_INTEGER);

                $update_result = $update_stmt->execute();

                if ($update_result) {
                    $update_stmt->close();
                    header("Location: ../Character.php?id=" . $id);
                    exit;
                } else {
                    echo "Error updating data: " . $conn->lastErrorMsg();
                }
            }
            $check_stmt->close();
        } else {
            echo "Error checking data: " . $conn->lastErrorMsg();
        }
    }
    $conn->close();
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
    <h1><?php echo ($character->getFirstName() . " " . $character->getLastName()) ?></h1>
        <form action="<?php echo 'EditPers.php?id=' . $searching ?>" method="POST">
            <label for="Likes">Likes:</label>
            <textarea id="Likes" name="Likes"><?php echo $character->getLikes(); ?></textarea>

            <label for="Dislikes">Dislikes:</label>
            <textarea id="Dislikes" name="Dislikes"><?php echo $character->getDislikes(); ?></textarea>

            <label for="Personality">Personality:</label>
            <textarea id="Personality" name="Personality"><?php echo $character->getPersonality(); ?></textarea>

            <label for="Background">Background:</label>
            <textarea id="Background" name="Background"><?php echo $character->getBackground(); ?></textarea>

            <input type="submit" name="update3" value="Edit" id="submit">
        </form>
    </div>
</body>

</html>