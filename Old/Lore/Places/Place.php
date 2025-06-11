<?php
include_once("../../Classes/DBConnection.php");
include_once("../../GlobalResources/SQLStuffis.php");
$id = $_GET['id'];

$event = getPlacebyId($id);
$chars = getCharactersRelatedtoPlace($id);
$region = getRegionbyId($event->getRegionId());

if (isset($_POST['submit'])) {
    $uploadDirectory = __DIR__ . '/../../images/Places/';

    $characterFolder = $uploadDirectory . $id;
    if (!is_dir($characterFolder)) {
        if (!mkdir($characterFolder, 0777, true)) {
            die('Failed to create folders...');
        }
    }

    $targetFile = $characterFolder . '/' . basename($_FILES['fileToUpload']['name']);
    if (isset($_FILES['fileToUpload']['tmp_name']) && is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
        if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "No file uploaded or file upload was not successful.";
    }
}

if (isset($_POST['edit'])) {
    header('Location: EditPlaces.php?id=' . $id);
}

if (isset($_POST['create'])) {
    header('Location: CreatePlaces.php');
}

if (isset($_POST['sortc'])) {
    header('Location: SortPLaceRuler.php?id=' . $id);
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
        <form action="" method="post" enctype="multipart/form-data">
            <input type="submit" value="Ort Bearbeiten" name="edit">
            <input type="submit" value="Ort Erstellen" name="create">
            <input type="submit" value="Ordne Herrscher/Besitzer zu" name="sortc">
        </form>
        <div class="page-content">
            <div class="table">
                <section class="character-info">
                    <h2>Ort Information</h2>
                </section>
                <section class="character-info">
                    <h3>Eigentümer oder Herrscher</h3>
                    <?php
                    foreach ($chars as $ch) {
                        echo "<p>" . $ch . "</p>";
                    }
                    ?>
                    <h3>Gehört zur Region</h3>
                    <?php
                    echo $region->getName()
                    ?>
                </section>
            </div>
            <div class="additional">
                <section class="personality">
                    <h2>Beschreibung</h2>
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