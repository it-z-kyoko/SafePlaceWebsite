<?php 
function ToolTip($Name,$Anzeigetext) {
    include_once("C:/xampp/htdocs/SafePlaceWebsite/Classes/DBConnection.php");
    $conn = DBConnection::getConnection();

    $sql = "SELECT * FROM tooltip WHERE Name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $Name, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result) {
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $output = '<div class="tooltip">';
        $output .= $Anzeigetext;
        $output .= '<div class="top"><h3>' . $row['Name']. '</h3>';
        $output .= '<p>' . $row['Description'] .'</p>';
        $output .= '<i></i></div></div>';
    }
    echo $output;
}

?>