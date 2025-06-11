<?php
include_once("Classes/DBConnection.php");

if (isset($_POST['birthday'])) {
    $month = $_POST['Month'];
    if ($month < 10) {
        $month = sprintf('%02d', $month);
    }
    $ca = DBConnection::ShowallBirthdaysofThisMonth($month);
    foreach ($ca as $character) {
        $date = date_create($character->getbirthday());
        $date = date_format($date, 'm-d');
        echo "/remind create remindtime:" . $date . "-" . date("Y") . "
        channel:<#993914824918585346> 
        remindmessage:Today is the birthday of " . $character->getfirstname() .
            " name:Birthdayof" . $character->getfirstname() . " 
        usedate:True <br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Stuffis</title>
</head>
<body>
    <form action="" method="post">
        <label for="Month">Month (nr)</label>
        <input type="text" value="" name="Month">
        <button type="submit" name="birthday">getBirthday</button>
    </form>
</body>
</html>