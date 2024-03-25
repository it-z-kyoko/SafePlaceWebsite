<?php

function extractNames($id, $conn)
        {
            if ($id != "") {
                $sql = "SELECT `First_Name` FROM `character` WHERE character_id = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1, $id, SQLITE3_NUM);
                $nameResult = $stmt->execute();

                if ($nameResult) {  // Check if the query execution was successful
                    $row = $nameResult->fetchArray(SQLITE3_ASSOC);

                    if ($row !== false) {
                        $name = $row['First_Name'];
                        $result = "<a href='Character.php?id=$id'>$name</a>";
                    } else {
                        $result = "Name not found for ID: $id";
                    }
                }
            }
            return $result;
        }
function ShowFamily($id)
{
    $searching = $id;

    $conn = DBConnection::getConnection();

    // SQL-Abfrage für den gewünschten Datensatz (Using prepared statement to prevent SQL injection)
    $sql = "SELECT * FROM character_family_role WHERE character_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $searching, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result) {
        

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            switch ($row['Role']) {
                case 'Parent':
                    $Parent[] = extractNames($row["Connected_Character"], $conn);
                    break;
                case 'Sibling':
                    $Sibling[] = extractNames($row["Connected_Character"], $conn);
                    break;
                case 'Child':
                    $Child[] = extractNames($row["Connected_Character"], $conn);
                    break;
                case 'Partner':
                    $Partner = extractNames($row["Connected_Character"], $conn);
                    break;
                default:
                    break;
            }
        }

        $output = "<table class='character-info'>";

        if (!empty($Parent)) {
            $output .= "<tr><th>Eltern</th>";
            foreach ($Parent as $p) {
                $output .= "<td>$p</td>";
            }
            $output .= "</tr>";
        }

        if (!empty($Sibling)) {
            $output .= "<tr><th>Geschwister</th>";
            foreach ($Sibling as $s) {
                $output .= "<td>$s</td>";
            }
            $output .= "</tr>";
        }

        if (!empty($Child)) {
            $output .= "<tr><th>Kinder</th>";
            foreach ($Child as $c) {
                $output .= "<td>$c</td>";
            }
            $output .= "</tr>";
        }

        if (!empty($Partner)) {
            $output .= "<tr><th>Partner</th>";
            $output .= "<td>$Partner</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";

        echo $output;
    } else {
        echo "Keine Daten gefunden.";
    }

    // Datenbankverbindung schließen
    $conn->close();
}


function ShowAbilities($id)
{
    include_once('../Classes/Abilities.php');
    $conn = DBConnection::getConnection();

    $sql = "SELECT * FROM character_ability WHERE character_id = $id";
    $result = $conn->query($sql);

    $ab = array();

    if ($result->numColumns() > 0) {
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ability = new Abilities(
                $row["character_id"],
                $row["Description"]
            );
            array_push($ab, $ability);
        }
    }

    if (!empty($ab)) {
        echo "<ul>";
        foreach ($ab as $ability) {
            echo "<li>" . $ability->getDescription() . "</li>";
        }
        echo "</ul>";
    }
}
