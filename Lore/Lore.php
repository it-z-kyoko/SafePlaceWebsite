<?php

include_once("../Classes/DBConnection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spielerübersicht</title>
    <link rel="shortcut icon" href="https://safeplace.infinityfreeapp.com/images/Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../Player/player.css">
</head>

<body>
    <div class="div-2">
        <div class="background-image"></div>
        <?php include("../GlobalResources/Navbar.php") ?>
        <div class="overview">
            <div class="player-container">
                <a href="Events/EventOverview.php">
                    <div class="player-content">
                        <div class="player-name">Events</div>
                    </div>
                </a>
            </div>
            <div class="player-container">
                <a href="Places/PlacesOverview.php">
                    <div class="player-content">
                        <div class="player-name">Places</div>
                    </div>
                </a>
            </div>
            <div class="player-container">
                <a href="Races/RaceOverview.php">
                    <div class="player-content">
                        <div class="player-name">Races</div>
                    </div>
                </a>
            </div>
            <div class="player-container">
                <a href="Regions/RegionOverview.php">
                    <div class="player-content">
                        <div class="player-name">Region</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="spacer">
            <input type="hidden" name="">
        </div>
    </div>
</body>

</html>

<style>
    .overview {
        display: grid;
        width: 60%;
        grid-template-columns: auto auto auto;
        justify-content: center;
        align-items: center;
        justify-items: center;
    }

    .player-container {
        display: flex;
        margin-top: 30px;
        padding-right: 10px;
        justify-content: center;
        gap: 20px;
        font-weight: 400;
        text-align: center;
        width: 80%;
        align-items: center;
    }

    .player-content {
        border-radius: 20px;
        background-color: #fff;
    }

    .player-content {
        box-shadow: 0px 2px 48px 0px rgba(0, 0, 0, 0.08);
        z-index: 10;
        display: flex;
        margin-top: -10px;
        flex-direction: column;
        padding: 24px 33px;
        flex-wrap: nowrap;
        align-content: center;
        justify-content: center;
        align-items: center;
    }

    .player-avatar {
        aspect-ratio: 1;
        object-fit: auto;
        object-position: center;
        width: 60px;
        align-self: center;
    }

    .player-name {
        color: #1e1e1e;
        letter-spacing: 0.25px;
        margin-top: 20px;
        white-space: nowrap;
        font: 15px/130% 'Raleway', sans-serif;
    }

    .player-description {
        color: #777;
        letter-spacing: 0.75px;
        margin-top: 10px;
        font: 12px/18px 'Raleway', sans-serif;
    }

    .spacer {
    height: 1000px
}
</style>