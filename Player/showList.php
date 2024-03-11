<?php
include_once("../Classes/DBConnection.php");
$id = $_GET["id"];
$ca = DBConnection::ShowAllPlayerCharactersWithoutPartners($id);
$output = "<h3>Charaktere ohne eingetragenen Partner</h3>";
echo $output;
foreach ($ca as $c) {
    echo "<p>". $c->getFirstname() . " " . $c->getlastname()."</p>";
}

?>
