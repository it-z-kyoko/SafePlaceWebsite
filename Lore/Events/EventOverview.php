<?php
include_once("../../Classes/DBConnection.php");
$test = DBConnection::getallEvents();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Events</title>
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../Lore.css">
    <link rel="shortcut icon" href="https://safeplace.infinityfreeapp.com/images/Logo.png" type="image/x-icon">
</head>

<body>
    <div class="div-2">

        <?php include("../../GlobalResources/Navbar.php") ?>
        <div class="background-image"></div>
        <div class="position">
            <img src="../../images/Event-Image.png" alt="" class="landscape">
            <div class="grid">
            <?php
            foreach ($test as $t) {
            ?>
                <div class="div-14">
                    <div class="div-15">
                        <a href="#">
                            <div class="div-16">
                                <div class="div-17"><?php echo $t->getName(); ?></div>
                                <div class="div-18"><?php echo $t->getShortDescription(); ?></div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php }
            ?>
            </div>
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
</style>