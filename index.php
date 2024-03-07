<?php
include_once("GlobalResources/GlobalFunktions.php");

CreateDatabase();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Startseite</title>
</head>

<body>
    <div class="div-2">
        <div class="background-image"></div>
        <?php include("GlobalResources/Navbar.php")?>
        <div class="div-14">
            <div class="div-15">
            <a href="Player/Player.php?name=Kyo">
                <div class="div-16">
                    <img loading="lazy" srcset="images/KyoAvatar.png" class="img-3" />
                    <div class="div-17">Kyo</div>
                    <div class="div-18">
                        Ersteller der Website
                    </div>
                </div>
                
            </div>
            <div class="div-15">
            <a href="Player/Player.php?name=Anni">
                <div class="div-16">
                    <img loading="lazy" srcset="images/AnniAvatar.png" class="img-3" />
                    <div class="div-17">Anni</div>
                    <div class="div-18">
                        Certified Villain Player
                    </div>
                </div>
            </a>
            </div>
            <div class="div-15">
            <a href="Player/Player.php?name=Lea">
                <div class="div-16">
                    <img loading="lazy" srcset="images/LeaAvatar.png" class="img-3" />
                    <div class="div-17">Lea</div>
                    <div class="div-18">
                        Gute Seele
                    </div>
                </div>
            </a>
            </div>
            <div class="div-15">
            <a href="calender.php">
                <div class="div-16">
                    <img loading="lazy"
                        srcset="images/BirthdayIcon.png"
                        class="img-3" />
                    <div class="div-17">Birthdays</div>
                    <div class="div-18">
                        You want to view upcoming Birthdays?
                    </div>
                </div>
                </a>
            </div>
            <div class="div-15">
                <div class="div-16">
                    <img loading="lazy"
                        srcset="images/DownloadIcon.png"
                        class="img-3" />
                    <div class="div-17">Export</div>
                    <div class="div-18">
                        You want to export something from the website?
                    </div>
                </div>
            </div>
            <div class="div-15">
                <div class="div-16">
                    <img loading="lazy"
                        srcset="images/InformationIcon.png"
                        class="img-3" />
                    <div class="div-17">Information</div>
                    <div class="div-18">
                        Searching for something?
                    </div>
                </div>
            </div>
        </div>
        <div class="textbox">
            <div class="div-51">Safe Place RP</div>
            <div class="div-52">
                Something aint working right? Write me a ticket or send a a DM on Discord!
            </div>
            <button class="TicketButton" type="button">Write a Ticket!</button>
        </div>
    </div>

</body>

</html>