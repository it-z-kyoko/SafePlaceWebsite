<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erstelle ein Lore-Event</title>
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../Lore.css">
    <link rel="stylesheet" href="../../Characters/Edit/Edit.css">
</head>

<body>
    <div class="background-image"></div>
    <div class="div-2">
        <?php include("../../GlobalResources/Navbar.php") ?>
        <div class="flex">
            <h1>Erstelle ein Event</h1>
            <form action="CreateEvents.php" method="post">
                <label for="Name">Name:</label>
                <input type="text" name="Name" id="Name">
                <select name="" id="">
                    <option value="Select">Select</option>
                    <option value="Vineet">Vineet Saini</option>
                    <option value="Sumit">Sumit Sharma</option>
                    <option value="Dorilal">Dorilal Agarwal</option>
                    <option value="Omveer">Omveer Singh</option>
                    <option value="Rohtash">Rohtash Kumar</option>
                    <option value="Maneesh">Maneesh Tewatia</option>
                    <option value="Priyanka">Priyanka Sachan</option>
                    <option value="Neha">Neha Saini</option>
                </select>
            </form>
            <div class="spacer">
                <input type="hidden" name="">
            </div>
        </div>
    </div>

</body>

</html>

<style>
    h1 {
        margin: 20px
    }
</style>