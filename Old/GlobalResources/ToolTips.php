<?php
function ToolTip($Name, $Anzeigetext)
{
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
        $output .= '<div class="top"><h3>' . $row['Name'] . '</h3>';
        $output .= '<p>' . $row['Description'] . '</p>';
        $output .= '<i></i></div></div>';
        $output .= '<style>
        h1 {
            margin: 20px
        }
    
        select {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #ffffff;
            font-family: inherit;
            font-size: inherit;
            width: 100%;
        }
    
        .tooltip {
            display: inline-block;
            position: relative;
            border-bottom: 1px dotted #666;
            text-align: left;
        }
    
        .tooltip h3 {
            margin: 12px 0;
        }
    
        .tooltip .top {
            min-width: 200px;
            max-width: 400px;
            top: -20px;
            left: 50%;
            transform: translate(-30%, -100%);
            padding: 10px 20px;
            color: #ffffff;
            background-color: #009;
            font-weight: normal;
            font-size: 14px;
            border-radius: 8px;
            position: absolute;
            z-index: 99999999;
            box-sizing: border-box;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.5);
            display: none;
        }
    
        .tooltip:hover .top {
            display: block;
        }
    
        .tooltip .top i {
            position: absolute;
            top: 100%;
            left: 30%;
            margin-left: -15px;
            width: 30px;
            height: 15px;
            overflow: hidden;
        }
    
        .tooltip .top i::after {
            content: "";
            position: absolute;
            width: 15px;
            height: 15px;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            background-color: #009;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.5);
        }
    </style>';
    }
    echo $output;
}
