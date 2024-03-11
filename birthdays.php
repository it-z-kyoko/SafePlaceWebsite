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

function renderBirthdays($birthdays)
{
    $htmlContent = '<div class="calendar">';
    
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