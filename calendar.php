<?php
include_once('Classes/DBConnection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle AJAX request for fetching birthdays based on the selected month
    $selectedMonth = $_POST['month'];
    if ($selectedMonth < 10) {
        $selectedMonth = sprintf('%02d', $selectedMonth);
    }
    $birthdays = DBConnection::ShowallBirthdaysofThisMonth($selectedMonth);
    $htmlContent = renderBirthdays($birthdays);
    echo $htmlContent;
    exit;
}

// Initial load or regular page load


$currentMonth = date('m');
if ($currentMonth < 10) {
    $currentMonth = sprintf('%02d', $currentMonth);
}
$birthdays = DBConnection::ShowallBirthdaysofThisMonth($currentMonth);
$currentYear = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
$birthdayDays = [];

foreach ($birthdays as $birthday) {
    $birthdayDays[date('d', strtotime($birthday->getBirthday()))] = $birthday;
}

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

function renderBirthdays($birthdays)
{
    $htmlContent = '';

    $htmlContent .= '<div class="calendar">';
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $birthdaysOnDay = array_filter($birthdays, function ($birthday) use ($day) {
            return date('j', strtotime($birthday->getBirthday())) == $day;
        });

        if (!empty($birthdaysOnDay)) {
            $htmlContent .= '<div class="day-tile birthday">';
            $htmlContent .= '<span class="date">' . $day . '</span><br>';
            foreach ($birthdaysOnDay as $birthday) {
                $htmlContent .= '<span class="name">' . $birthday->getFirstname() . '</span><br>';
            }
        } else {
            $htmlContent .= '<div class="day-tile">';
            $htmlContent .= '<span class="date no-birthday">' . $day . '</span>';
        }

        $htmlContent .= '</div>';
    }

    $htmlContent .= '</div>';

    return $htmlContent;
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
        <input id="currentMonth" value="<?php echo $currentMonth; ?>">
        <div class="month-slider">
            
            <button id="prevMonth">Previous Month</button>
            <button id="nextMonth">Next Month</button>
            <div id="birthdaysContainer">
                <?php echo renderBirthdays($birthdays); ?>
            </div>
        </div>
    </div>

    <!-- Add your existing script and style content here -->
    <!-- ... -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- ... -->
<script>
    $(document).ready(function () {
        // Initial load
        loadBirthdays(<?php echo $currentMonth; ?>);

        // Click event for next month
        $('#nextMonth').on('click', function () {
            var nextMonth = parseInt($('#currentMonth').val()) + 1;
            if (nextMonth > 12) {
                nextMonth = 1;
            }
            loadBirthdays(nextMonth);
        });

        // Click event for previous month
        $('#prevMonth').on('click', function () {
            var prevMonth = parseInt($('#currentMonth').val()) - 1;
            if (prevMonth < 1) {
                prevMonth = 12;
            }
            loadBirthdays(prevMonth);
        });

        // Function to load birthdays for the selected month
        function loadBirthdays(month) {
            $.ajax({
                url: 'birthdays.php',
                type: 'POST',
                data: { month: month },
                success: function (data) {
                    $('#birthdaysContainer').html(data);
                    $('#currentMonth').val(month);
                }
            });
        }
    });
</script>
<!-- ... -->


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