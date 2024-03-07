<?php
include_once('Classes/DBConnection.php');
$birthdays = DBConnection::ShowallBirthdaysofThisMonth();

// Create an associative array to store birthdays indexed by day
$birthdayDays = [];
foreach ($birthdays as $birthday) {
    $birthdayDays[date('d', strtotime($birthday->getBirthday()))] = $birthday;
}

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

function getBirthdaysByMonth($birthdays, $month)
{
    $birthdaysInMonth = [];

    foreach ($birthdays as $birthday) {
        $birthdayMonth = date('n', strtotime($birthday->getBirthday()));
        if ($birthdayMonth == $month) {
            $birthdaysInMonth[] = $birthday;
        }
    }

    return $birthdaysInMonth;
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geburtstagskalender</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="div-2">
        <div class="background-image"></div>
        <?php include("GlobalResources/Navbar.php") ?>
        <div class="month-slider">
            <?php
            // Iteriere durch alle Monate des Jahres
            for ($month = 1; $month <= 12; $month++) {
                $birthdays = DBConnection::ShowallBirthdaysofThisMonth();
                $birthdaysInMonth = getBirthdaysByMonth($birthdays, $month);

                echo '<div class="month-container">';
                echo '<h2>' . date('F', mktime(0, 0, 0, $month, 1)) . '</h2>'; // Monatsname anzeigen

                // Zeige alle Tage im Monat an
                echo '<div class="calendar">';
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));

                for ($day = 1; $day <= $daysInMonth; $day++) {
                    echo '<div class="day-tile">';

                    // Wenn es Geburtstage an diesem Tag gibt, markiere und zeige die Namen an
                    $birthdaysOnDay = array_filter($birthdaysInMonth, function ($birthday) use ($day) {
                        return date('j', strtotime($birthday->getBirthday())) == $day;
                    });

                    if (!empty($birthdaysOnDay)) {
                        echo '<span class="date">' . $day . '</span><br>';
                        foreach ($birthdaysOnDay as $birthday) {
                            echo '<span class="name">' . $birthday->getFirstname() . '</span><br>';
                        }
                    } else {
                        echo '<span class="date no-birthday">' . $day . '</span>';
                    }

                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>

</html>


<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .calendar {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        max-width: 800px;
        padding: 20px;
    }

    .birthday-tile {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

    }

    .date {
        font-weight: bold;
        font-size: 18px;
    }

    .name {
        margin-top: 5px;
        font-size: 14px;
    }

    /* Add these styles to your existing styles.css file */
    .day-tile {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(15px);
        background: rgba(25, 25, 25, 0.2);
    }

    .birthday {
        background-color: #ffc0cb;
    }
</style>