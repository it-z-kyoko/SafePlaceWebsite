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

function showList($id)
{
    $ca = DBConnection::ShowAllPlayerCharactersWithoutPartners($id);
    $output = "";
    foreach ($ca as $c) {
        $output .= $c->getfirstname();
    }
    var_dump($output);
    return $output;
}

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
                        <button id="showListButton" onclick="loadList()">Liste anzeigen</button>
                    </div>
                </div>
                <div id="popup">
                    <span id="closePopup">X</span>
                    <div id="listContainer"></div>
                </div>


                <script>
                    document.getElementById('showListButton').addEventListener('click', function() {
                        document.getElementById('popup').style.display = 'block';
                    });

                    function loadList() {
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                document.getElementById("listContainer").innerHTML = xhr.responseText;
                            }
                        };
                        xhr.open("GET", "showList.php?id=<?php echo $id; ?>", true);
                        xhr.send();
                    }

                    document.getElementById('closePopup').addEventListener('click', function() {
                        // Pop-Up ausblenden
                        document.getElementById('popup').style.display = 'none';
                    });
                </script>
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

<style>
    #popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        z-index: 1000;
        height: 80%;
        width: 50%;
        overflow: scroll;
        background-color: #1a1a1a;
        color: #fff;
    }

    #closePopup {
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    #closePopup:hover {
        color: #555;
        /* Textfarbe bei Hover anpassen */
    }

    ::-webkit-scrollbar {
        width: 12px;
        /* Breite der Scrollbar */
    }

    ::-webkit-scrollbar-thumb {
        background-color: #888;
        /* Farbe des Scrollbar-Griffs */
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #555;
        /* Farbe des Scrollbar-Griffs bei Hover */
    }

    #listContainer {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        align-content: center;
        justify-content: space-evenly;
        align-items: center;
    }
</style>