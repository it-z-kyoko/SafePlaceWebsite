<?php
include_once("../../Classes/DBConnection.php");
$id = $_GET['id'];
$event = DBConnection::getEventbyId($id);
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
                    <form method="post" action="">
                        <button class="edit" type="submit" name="info">
                            <i class="fas fa-edit" style="color:black; background-color:#fff;border:0;"></i>
                        </button>
                    </form>
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
            </div>
        </div>


        <div class="spacer">
            <input type="hidden" name="">
        </div>
    </div>
</body>

</html>

<style type="text/css">
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
        width: 30%;
        margin-left: 80px;
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
</style>