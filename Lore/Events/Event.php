<?php
include_once("../../Classes/DBConnection.php");
include_once("../../GlobalResources/SQLStuffis.php");
$id = $_GET['id'];

$event = DBConnection::getEventbyId($id);
$chars = getCharacterRelatedToEvent($id);
$race = getRacesRelatedToEvent($id);

if (isset($_POST['submit'])) {
    $uploadDirectory = "../../images/Events/";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $event->getName(); ?></title>
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../Lore.css">
    <link rel="stylesheet" href="../../Characters/Characters.css">
</head>

<body>
    <div class="div-2">
        <?php include("../../GlobalResources/Navbar.php") ?>
        <div class="background-image"></div>
        <h1 class="page-header">
            <?php echo $event->getName() ?>
        </h1>
        <div class="page-content">
            <div class="table">
                <section class="character-info">
                    <h2>Event Information</h2>
                    <h3>Kurz-Beschreibung</h3>
                    <p class="break">
                        <?php
                        if ($event->getShortDescription() == "") {
                            echo "Keine Kurzbeschreibung vorhanden";
                        } else {
                            echo $event->getShortDescription();
                        }
                        ?>
                    </p>
                </section>
                <section class="character-info">
                    <h3>Involvierte oder Betroffene Charaktere</h3>
                    <?php
                    foreach ($chars as $ch) {
                        echo "<p>" . $ch . "</p>";
                    }
                    ?>
                    <h3>Involvierte oder Betroffene Völker</h3>
                    <?php
                    foreach ($race as $r) {
                        echo "<p>" . $r . "</p>";
                    }
                    ?>
                </section>
            </div>
            <div class="additional">
                <section class="personality">
                    <h2>Beschreibung</h2>
                    <form method="post" action="">
                        <button class="edit" type="submit" name="pers">
                            <i class="fas fa-edit" style="color:black; background-color:#fff;border:0;"></i>
                        </button>
                    </form>
                    <p><?php echo $event->getDescription() ?></p>
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
        <div class="spacer">
            <input type="hidden" name="">
        </div>
    </div>
</body>

</html>

<style type="text/css">
    h1,
    h2,
    h3 {
        padding: 20px;
    }

    .position {
        width: 80%;
        display: flex !important;
        flex-direction: column;
        align-content: center;
        justify-content: center;
        align-items: center;
    }

    .landscape {
        height: 400px;
        margin: 20px
    }

    .grid {
        display: grid !important;
        grid-template-columns: auto auto auto auto;
        width: 100%;
    }

    .div-14 {
        width: 100% !important;
    }

    .div-15 {
        width: 100% !important;
        min-height: 100px;
    }

    .break {
        word-wrap: break-word;
        width: 20%;
        margin-left: 20px;
    }

    .table {
        display: flex !important;
        flex-direction: column;
        align-content: center;
        align-items: center;
    }

    .character-info {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-content: center;
        align-items: center;
    }

    /* Gemeinsame Stile für verschiedene Bildschirmgrößen */
    h1,
    h2,
    h3 {
        padding: 10px;
    }

    .break {
        word-wrap: break-word;
        margin-left: 10px;
        margin-right: 10px;
        text-align: center;
    }

    /* Tablet- und Desktop-Stile */
    @media only screen and (min-width: 768px) {
        .page-content {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .div-2 {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .table {
            flex: 1;
            max-width: 50%;
        }

        .additional {
            flex: 1;
            max-width: 50%;
        }
    }

    /* Mobile-Stile */
    @media only screen and (max-width: 767px) {
        .break {
            width: 100%;
        }
    }
</style>