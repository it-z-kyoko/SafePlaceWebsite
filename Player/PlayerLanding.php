<?php

include_once("../Classes/DBConnection.php");
$caK = DBConnection::SelectAllCharactersbyPlayerid(1);
$caL = DBConnection::SelectAllCharactersbyPlayerid(2);
$caA = DBConnection::SelectAllCharactersbyPlayerid(3);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spielerübersicht</title>
    <link rel="shortcut icon" href="https://safeplace.infinityfreeapp.com/images/Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="player.css">
</head>

<body>
    <div class="div-2">
        <div class="background-image"></div>
        <?php include("../GlobalResources/Navbar.php") ?>
        <div class="overview">
            <div class="player-container">
                <a href="Player.php?name=Kyo">
                    <div class="player-content">
                        <img loading="lazy" srcset="../images/KyoAvatar.png" class="player-avatar" />
                        <div class="player-name">Kyo</div>
                        <div class="player-description">
                            Ersteller der Website
                        </div>
                        <div class="player-description">
                            <p><strong>Anzahl der Charaktere:</strong> <?php echo sizeof($caK); ?></p>
                        </div>
                        <div class="player-description">
                            <?php
                            $w = 0;
                            $d = 0;
                            $m = 0;
                            foreach ($caK as $character) {
                                $g = $character->getGender();
                                switch ($g) {
                                    case 'W':
                                        $w += 1;
                                        break;
                                    case 'D':
                                        $d += 1;
                                        break;
                                    case 'M':
                                        $m += 1;
                                        break;
                                    default:
                                        break;
                                }
                            } ?>
                            <p><strong>Weibliche Charaktere: </strong><?php echo $w ?></p>
                            <p><strong>Männliche Charaktere: </strong><?php echo $m ?></p>
                            <p><strong>Geschlechtslose Charaktere: </strong><?php echo $d ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="player-container">
                <a href="Player.php?name=Anni">
                    <div class="player-content">
                        <img loading="lazy" srcset="../images/AnniAvatar.png" class="player-avatar" />
                        <div class="player-name">Anni</div>
                        <div class="player-description">
                            Ersteller der Website
                        </div>
                        <div class="player-description">
                            <p><strong>Anzahl der Charaktere:</strong> <?php echo sizeof($caA); ?></p>
                        </div>
                        <div class="player-description">
                            <?php
                            $w = 0;
                            $d = 0;
                            $m = 0;
                            foreach ($caA as $character) {
                                $g = $character->getGender();
                                switch ($g) {
                                    case 'W':
                                        $w += 1;
                                        break;
                                    case 'D':
                                        $d += 1;
                                        break;
                                    case 'M':
                                        $m += 1;
                                        break;
                                    default:
                                        break;
                                }
                            } ?>
                            <p><strong>Weibliche Charaktere: </strong><?php echo $w ?></p>
                            <p><strong>Männliche Charaktere: </strong><?php echo $m ?></p>
                            <p><strong>Geschlechtslose Charaktere: </strong><?php echo $d ?></p>
                        </div>
                    </div>

                </a>
            </div>
            <div class="player-container">
                <a href="Player.php?name=Lea">
                    <div class="player-content">
                        <img loading="lazy" srcset="../images/LeaAvatar.png" class="player-avatar" />
                        <div class="player-name">Lea</div>
                        <div class="player-description">
                            Ersteller der Website
                        </div>
                        <div class="player-description">
                            <p><strong>Anzahl der Charaktere:</strong> <?php echo sizeof($caL); ?></p>
                        </div>
                        <div class="player-description">
                            <?php
                            $w = 0;
                            $d = 0;
                            $m = 0;
                            foreach ($caL as $character) {
                                $g = $character->getGender();
                                switch ($g) {
                                    case 'W':
                                        $w += 1;
                                        break;
                                    case 'D':
                                        $d += 1;
                                        break;
                                    case 'M':
                                        $m += 1;
                                        break;
                                    default:
                                        break;
                                }
                            } ?>
                            <p><strong>Weibliche Charaktere: </strong><?php echo $w ?></p>
                            <p><strong>Männliche Charaktere: </strong><?php echo $m ?></p>
                            <p><strong>Geschlechtslose Charaktere: </strong><?php echo $d ?></p>
                        </div>
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