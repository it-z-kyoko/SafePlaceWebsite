<?php
include_once("../Classes/DBConnection.php");
$id = $_GET["id"];
$ca = DBConnection::ShowAllPlayerCharactersWithoutPartners($id);
$output = "";
foreach ($ca as $c) {
    echo "<p>". $c->getFirstname() . " " . $c->getlastname()."</p><br> ";
}
echo $output;
?>
