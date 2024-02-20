<?php
include_once('../Classes/DBConnection.php');
include_once('../Classes/Abilities.php');
$conn = DBConnection::getConnection();

$sql = "SELECT * FROM character_ability WHERE character_id = $id";
$result = $conn->query($sql);

$ab = array();

if ($result->numColumns() > 0) {
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $ability = new Abilities(
            $row["character_id"],
            $row["Describtion"]
        );
        array_push($ab, $ability);
    }
}

if (!empty($ab)) {
?>
    <ul>
        <?php
        foreach ($ab as $ability) {
        ?>
            <li><?php echo $ability->getDescription(); ?></li>
        <?php } ?>
    </ul>
<?php
}
?>
