<?php
include_once("../GlobalResources/GlobalFunktions.php");
$id = $_GET["id"];

include_once("../Classes/DBConnection.php");

$character = DBConnection::SelectCharacterbyCharacterid($id);
switch ($character->getPlayer()) {
    case '1':
        $path = '../images/KyoGalaxy.jpg';
        $pid = 1;
        break;
    case '3':
        $path = '../images/AnniGalaxy.jpg';
        $pid = 3;
        break;
    case '2':
        $path = '../images/LeaGalaxy.jpg';
        $pid = 2;
        break;
    default:
        $path = '../images/BackgroundLanding.jpg';
        break;
}

if (isset($_POST["family"])) {
    $zielUrl = 'Edit/EditFamily.php?id=' . $id;
    header("Location: $zielUrl");
    exit;
}

if (isset($_POST["info"])) {
    $zielUrl = 'Edit/EditInfo.php?id=' . $id;
    header("Location: $zielUrl");
    exit;
}

if (isset($_POST["pers"])) {
    $zielUrl = 'Edit/EditPers.php?id=' . $id;
    header("Location: $zielUrl");
    exit;
}

if (isset($_POST["back"])) {
    $zielUrl = 'Edit/EditBack.php?id=' . $id;
    header("Location: $zielUrl");
    exit;
}

if (isset($_POST["ab"])) {
    $zielUrl = 'Edit/Editab.php?id=' . $id;
    header("Location: $zielUrl");
    exit;
}

if (isset($_POST['submit'])) {
    $uploadDirectory = "../images/";

    $characterFolder = $uploadDirectory . $id;
    if (!is_dir($characterFolder)) {
        mkdir($characterFolder);
    }

    $targetFile = $characterFolder . '/' . basename($_FILES['fileToUpload']['name']);

    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
    } else {
        echo "Beim Hochladen der Datei ist ein Fehler aufgetreten.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $character->getFirstname() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Characters.css">
    <script src="https://kit.fontawesome.com/3f2a1fd1ed.js" crossorigin="anonymous"></script>
    <link rel="icon" href="#" type="image/x-icon">
</head>

<style>
    .background-image {
        background-image: url('<?php echo $path; ?>');
    }
</style>

<body>
    <div class="div-2">
        <div class="background-image"></div>
        <?php include("../GlobalResources/Navbar.php") ?>
        <h1 class="page-header">
            <?php echo $character->getFirstname() . " " . $character->getLastname() ?>
        </h1>
        <div class="page-content">
            <div class="table">
                <!-- Character Information -->
                <section class="character-info">
                    <h2>Character Information</h2>
                    <form method="post" action="">
                    <button class="edit" type="submit" name="info">
                    <i class="fas fa-edit" style="color:black; background-color:#fff;border:0;"></i>
                </button>
                </form>
                    <table>
                        <tr>
                            <th>Spitzname</th>
                            <td>
                                <?php
                                if ($character->getNickname() == "") {
                                    echo "Keine Spitznamen";
                                } else {
                                    echo $character->getNickname();
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Alter</th>
                            <td>
                                <?php
                                if ($character->getChild() == 1) {
                                    echo "<p>Altert im RP</p>";
                                } elseif ($character->getAge() == "") {
                                    echo "unbekannt";
                                } else {
                                    echo $character->getAge();
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Volk</th>
                            <td>
                                <?php echo $character->getRace() ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Geburtstag</th>
                            <td>
                                <?php
                                if ($character->getBirthday() == "") {
                                    echo "Geburtstag unbekannt";
                                } else {
                                    $date = date_create($character->getBirthday());
                                    echo date_format($date, "d.m");
                                }


                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Geschlecht</th>
                            <td>
                                <?php
                                if ($character->getGender() == 'W') {
                                    echo "<p>Weiblich</p>";
                                } elseif ($character->getGender() == 'M') {
                                    echo "<p>Männlich</p>";
                                } elseif ($character->getGender() == 'D') {
                                    echo "<p>Divers</p>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Größe</th>
                            <td>
                                <?php
                                if ($character->getHeight() == "") {
                                    echo "Keine Größe angegeben";
                                } else {
                                    $height = $character->getHeight() / 100;
                                    echo $height . "m";
                                }

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Gewicht</th>
                            <td>
                                <?php
                                if ($character->getWeight() == "") {
                                    echo "Kein Gewicht angegeben";
                                } else {
                                    echo $character->getWeight() . " kg";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </section>
                <section class="Family">
                    <h2>Family</h2>
                    <form method="post" action="">
                    <button class="edit" type="submit" name="family">
                    <i class="fas fa-edit" style="color:black; background-color:#fff;border:0;"></i>
                </button>
                </form>
                    <?php ShowFamily($id)?>
                </section>
            </div>
            <div class="additional">
                <section class="personality">
                    <h2>Persönlichkeit</h2>
                    <form method="post" action="">
                    <button class="edit" type="submit" name="pers">
                    <i class="fas fa-edit" style="color:black; background-color:#fff;border:0;"></i>
                </button>
                </form>
                    <p>
                        <b>Vorlieben: </b>
                        <?php
                        if ($character->getLikes() == "") {
                            echo "Keine Vorlieben angegeben";
                        } else {
                            echo $character->getLikes();
                        }
                        ?>
                        <br><br>
                        <b>Abneigungen: </b>
                        <?php
                        if ($character->getDislikes() == "") {
                            echo "Keine Abneigungen angegeben";
                        } else {
                            echo $character->getDislikes();
                        }
                        ?>
                        <br><br>
                        <?php
                        if ($character->getPersonality() == "") {
                            echo "Keine Persönlichkeit angegeben";
                        } else {
                            echo $character->getPersonality();
                        }
                        ?>
                    </p>
                </section>

                <section class="background">
                    <h2>Background</h2>
                    <form method="post" action="">
                    <button class="edit" type="submit" name="back">
                    <i class="fas fa-edit" style="color:black; background-color:#fff;border:0;"></i>
                </button>
                </form>
                    <p>
                        <?php
                        if ($character->getBackground() == "") {
                            echo "Keinen Hintergrund angegeben";
                        } else {
                            echo $character->getBackground();
                        }
                        ?>
                    </p>
                </section>

                <section class="abilities">
                    <h2>Abilities</h2>
                    <form method="post" action="">
                    <button class="edit" type="submit" name="ab">
                    <i class="fas fa-edit" style="color:black; background-color:#fff;border:0;"></i>
                </button>
                </form>
                    <?php ShowAbilities($id)?>
                    
                </section>

                <section class="image-gallery">
                    <h2>Image Gallery</h2>
                    <?php include("ImageGallery.php") ?>
                </section>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Bild hochladen" name="submit">
                </form>
            </div>
        </div>



    </div>



</body>

</html>