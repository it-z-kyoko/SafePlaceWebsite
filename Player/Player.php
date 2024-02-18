<?php
$name = $_GET["name"];
switch ($name) {
    case 'Kyo':
        $path = '../images/KyoGalaxy.jpg';
        $id = 1;
        break;
    case 'Anni':
        $path = '../images/AnniGalaxy.jpg';
        $id = 3;
        break;
    case 'Lea':
        $path = '../images/LeaGalaxy.jpg';
        $id = 2;
        break;
    default:
        $path = '../images/BackgroundLanding.jpg';
        break;
}

include_once("../Classes/DBConnection.php");
$ca = DBConnection::SelectAllCharactersbyPlayerid($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="player.css">
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
        <div class="container">
            <div>
                <div class="sidebar">
                    <h2>Player Info</h2>
                    <div class="player-info">
                        <p><strong>Name:</strong> <?php echo $name ?></p>
                    </div>
                    <div class="player-info">
                        <p><strong>Anzahl der Charaktere:</strong> <?php echo sizeof($ca); ?></p>
                    </div>
                    <div class="player-info">
                        <?php
                        $w = 0;
                        $d = 0;
                        $m = 0;
                        foreach ($ca as $character) {
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
                                    // Add a debug statement to check the value of $g
                                    //echo "Unknown gender: $g <br>";
                                    break;
                            }
                        } ?>
                        <p><strong>Charakter Statistik:</strong></p>
                        <p><strong>Weibliche Charaktere: </strong><?php echo $w ?></p>
                        <p><strong>Männliche Charaktere: </strong><?php echo $m ?></p>
                        <p><strong>Geschlechtslose Charaktere: </strong><?php echo $d ?></p>
                    </div>
                </div>
            </div>
            <div class="character-list">
                <?php
                foreach ($ca as $character) {
                    $datei = '../Characters/Character.php?id=' . $character->getID();
                ?>
                    <div class="character">
                        <div class="character-name"><a href="<?php echo $datei ?>">
                                <?php echo $character->getfirstname() . " " . $character->getlastname(); ?>
                            </a></div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>