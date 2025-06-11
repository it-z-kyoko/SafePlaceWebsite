<?php
include_once("Classes/DBConnection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Character Sheet Input</title>
</head>

<body>
    <h2>Character Sheet Input</h2>
    <form action="CharacterSheetInput.php" method="post">
        <textarea name="sheet" id="sheet" cols="30" rows="10"></textarea><br>
        <input type="submit" value="Analyze">
    </form>

    <hr>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sheet"])) {
        // Den Text aus dem Formular erhalten
        $character_sheet = $_POST['sheet'];

        // Muster für die verschiedenen Informationen definieren
        $keywords = array(
            'Name', 'Spitzname', 'Alter', 'Volk', 'Geburtstag',
            'Geschlecht', 'Sexualität', 'Größe', 'Gewicht', 'Persönlichkeit',
            'Vorlieben', 'Abneigungen', 'Fähigkeiten', 'Stärken', 'Schwächen',
            'Ausrüstung', 'Weiteres', 'Story', 'Hintergrund', 'Alias', 'Rasse', 
            'Merkmale','Optische Besonderheiten', 'Titel','Beruf'
        );

        // Array für die gefundenen Informationen
        $character_info = array();

        // Durch die Keywords iterieren und Informationen finden
        foreach ($keywords as $keyword) {
            // Versuchen, das Schlüsselwort im Text zu finden
            $pos = strpos($character_sheet, $keyword);
            if ($pos !== false) {
                // Falls das Schlüsselwort gefunden wurde
                // Extrahiere den Wert bis zum nächsten Schlüsselwort
                $start_pos = $pos + strlen($keyword);
                $end_pos = PHP_INT_MAX;
                foreach ($keywords as $next_keyword) {
                    $next_pos = strpos($character_sheet, $next_keyword, $start_pos);
                    if ($next_pos !== false && $next_pos < $end_pos) {
                        $end_pos = $next_pos;
                    }
                }
                $value = substr($character_sheet, $start_pos, $end_pos - $start_pos);
                $value = trim(str_replace(':', '', $value));
                // Wenn das Keyword 'Fähigkeiten' ist, teile den Wert in ein Array auf
                if ($keyword === 'Fähigkeiten') {
                    // Entferne das • und das "o" am Anfang jeder Fähigkeit
                    $value = preg_replace('/^\x{2022}|o |- |-\s*/um', '', $value);
                    // Teile den Wert an Zeilenumbrüchen auf, um einzelne Fähigkeiten zu erhalten
                    $abilities = explode("\n", $value);
                    // Entferne leere Einträge und führende oder abschließende Leerzeichen aus jeder Fähigkeit
                    $abilities = array_map('trim', array_filter($abilities));
                    // Weise das Array der Variable zu
                    $character_info[$keyword] = $abilities;
                } else {
                    // Für andere Keywords einfach den Wert zuweisen
                    $character_info[$keyword] = $value;
                }
            } else {
                $character_info[$keyword] = "";
            }
        }


        $name = $character_info['Name'];
        // Annahme: $name enthält den vollständigen Namen
        $parts = explode(' ', trim($name));
        $firstname = $parts[0]; // Erster Name vor dem ersten Leerzeichen
        $lastname = array_pop($parts); // Letzter Name nach dem letzten Leerzeichen
        $middlename = implode(' ', $parts); // Alles dazwischen

        // Korrektur des Mittelnamens, wenn es keinen gibt
        if (count($parts) == 1) {
            $middlename = ''; // Kein Mittelname vorhanden
        }

        // Verwendung der Variablen im Array oder an anderer Stelle
        $character_info['Firstname'] = $firstname;
        $character_info['Middlename'] = $middlename;
        $character_info['Lastname'] = $lastname;

        $spitzname = $character_info['Spitzname'] . $character_info['Alias'];
        $alter = $character_info['Alter'];
        $volk = $character_info['Volk'] . $character_info['Rasse'];
        $geburtstag = strtotime($character_info['Geburtstag']);
        $geschlecht = $character_info['Geschlecht'];
        $sexualität = $character_info['Sexualität'];
        $größe = $character_info['Größe'];
        $gewicht = $character_info['Gewicht'];
        $persönlichkeit = $character_info['Persönlichkeit'];
        $vorlieben = $character_info['Vorlieben'];
        $abneigungen = $character_info['Abneigungen'];
        $stärken = $character_info['Stärken'];
        $schwächen = $character_info['Schwächen'];
        $ausrüstung = $character_info['Ausrüstung'];
        $weiteres = $character_info['Weiteres'] . $character_info['Story'] . $character_info['Hintergrund'];
        

        // Ausgabe der extrahierten Informationen in Formularfeldern
    ?>
        <h2>Extrahierte Informationen:</h2>
        <form action="CharacterSheetInput.php" method="post">

            <select name="Player" id="Player">
                <?php
                $players = [
                    1 => 'Kyo',
                    3 => 'Anni',
                    2 => 'Lea'
                ];
                foreach ($players as $value => $pname) {
                    echo "<option value='$value'>$pname</option>";
                }
                ?>
            </select><br>

            <!-- Name -->
            <label for="fname">Name:</label>
            <textarea id="fname" name="fname" cols="30" rows="5"><?php echo $firstname; ?></textarea>
            <input type="checkbox" name="check_name" value="1"><br>

            <label for="mname">Name:</label>
            <textarea id="mname" name="mname" cols="30" rows="5"><?php echo $middlename; ?></textarea>
            <input type="checkbox" name="check_name" value="1"><br>

            <label for="lname">Name:</label>
            <textarea id="lname" name="lname" cols="30" rows="5"><?php echo $lastname; ?></textarea>
            <input type="checkbox" name="check_name" value="1"><br>

            <!-- Spitzname -->
            <label for="spitzname">Spitzname:</label>
            <textarea id="spitzname" name="spitzname" cols="30" rows="5"><?php echo $spitzname; ?></textarea>
            <input type="checkbox" name="check_spitzname" value="1"><br>

            <!-- Alter -->
            <label for="alter">Alter:</label>
            <textarea id="alter" name="alter" cols="30" rows="5"><?php echo $alter; ?></textarea>
            <input type="checkbox" name="check_alter" value="1"><br>

            <!-- Volk -->
            <label for="volk">Volk:</label>
            <textarea id="volk" name="volk" cols="30" rows="5"><?php echo $volk; ?></textarea>
            <input type="checkbox" name="check_volk" value="1"><br>

            <!-- Geburtstag -->
            <label for="geburtstag">Geburtstag:</label>
            <input type="date" name="geburtstag" id="geburtstag" value="<?php echo $geburtstag; ?>">
            <input type="checkbox" name="check_geburtstag" value="1"><br>

            <!-- Geschlecht -->
            <label for="geschlecht">Geschlecht:</label>
            <textarea id="geschlecht" name="geschlecht" cols="30" rows="5"><?php echo $geschlecht; ?></textarea>
            <input type="checkbox" name="check_geschlecht" value="1"><br>

            <!-- Sexualität -->
            <label for="sexualität">Sexualität:</label>
            <textarea id="sexualität" name="sexualität" cols="30" rows="5"><?php echo $sexualität; ?></textarea>
            <input type="checkbox" name="check_sexualität" value="1"><br>

            <!-- Größe -->
            <label for="größe">Größe:</label>
            <textarea id="größe" name="größe" cols="30" rows="5"><?php echo $größe; ?></textarea>
            <input type="checkbox" name="check_größe" value="1"><br>

            <!-- Gewicht -->
            <label for="gewicht">Gewicht:</label>
            <textarea id="gewicht" name="gewicht" cols="30" rows="5"><?php echo $gewicht; ?></textarea>
            <input type="checkbox" name="check_gewicht" value="1"><br>

            <!-- Persönlichkeit -->
            <label for="persönlichkeit">Persönlichkeit:</label>
            <textarea id="persönlichkeit" name="persönlichkeit" cols="30" rows="5"><?php echo $persönlichkeit; ?></textarea>
            <input type="checkbox" name="check_persönlichkeit" value="1"><br>

            <!-- Vorlieben -->
            <label for="vorlieben">Vorlieben:</label>
            <textarea id="vorlieben" name="vorlieben" cols="30" rows="5"><?php echo $vorlieben; ?></textarea>
            <input type="checkbox" name="check_vorlieben" value="1"><br>

            <!-- Abneigungen -->
            <label for="abneigungen">Abneigungen:</label>
            <textarea id="abneigungen" name="abneigungen" cols="30" rows="5"><?php echo $abneigungen; ?></textarea>
            <input type="checkbox" name="check_abneigungen" value="1"><br>

            <!-- Stärken -->
            <label for="stärken">Stärken:</label>
            <textarea id="stärken" name="stärken" cols="30" rows="5"><?php echo $stärken; ?></textarea>
            <input type="checkbox" name="check_stärken" value="1"><br>

            <!-- Schwächen -->
            <label for="schwächen">Schwächen:</label>
            <textarea id="schwächen" name="schwächen" cols="30" rows="5"><?php echo $schwächen; ?></textarea>
            <input type="checkbox" name="check_schwächen" value="1"><br>

            <!-- Ausrüstung -->
            <label for="ausrüstung">Ausrüstung:</label>
            <textarea id="ausrüstung" name="ausrüstung" cols="30" rows="5"><?php echo $ausrüstung; ?></textarea>
            <input type="checkbox" name="check_ausrüstung" value="1"><br>

            <!-- Weiteres -->
            <label for="weiteres">Weiteres:</label>
            <textarea id="weiteres" name="weiteres" cols="30" rows="5"><?php echo $weiteres; ?></textarea>
            <input type="checkbox" name="check_weiteres" value="1"><br>

            <!-- Fähigkeiten -->
            <label for="fähigkeiten">Fähigkeiten:</label>
            <ul>
                <?php
                $ciarray = $character_info['Fähigkeiten'];
                foreach ($ciarray as $index => $ability) { ?>
                    <li>
                        <textarea name="fähigkeit[]" cols="30" rows="5"><?php echo $ability; ?></textarea>
                        <input type="checkbox" name="check_fähigkeit[<?php echo $index; ?>]" value="1"><br>
                    </li>
                <?php } ?>
            </ul>

            <input type="submit" value="Bearbeiten abgeschlossen" name="edit">

        </form>
    <?php } ?>
</body>

</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    // Den Text aus dem Formular erhalten
    $firstname = $_POST['fname'];
    $middlename = $_POST['mname'];
    $lastname = $_POST['lname'];
    $spitzname = $_POST['spitzname'];
    $alter = $_POST['alter'];
    $volk = $_POST['volk'];
    $geburtstag = $_POST['geburtstag'];
    $geschlecht = $_POST['geschlecht'];
    $sexualität = $_POST['sexualität'];
    $größe = $_POST['größe'];
    $gewicht = $_POST['gewicht'];
    $persönlichkeit = $_POST['persönlichkeit'];
    $vorlieben = $_POST['vorlieben'];
    $abneigungen = $_POST['abneigungen'];
    $stärken = $_POST['stärken'];
    $schwächen = $_POST['schwächen'];
    $ausrüstung = $_POST['ausrüstung'];
    $weiteres = $_POST['weiteres'];
    $player = $_POST['Player'];
    

    // Fähigkeiten
    $fähigkeiten = $_POST['fähigkeit'];

    // Hier kannst du mit den gespeicherten Werten arbeiten, z.B. sie in einer Datenbank speichern oder anderweitig verarbeiten.

    // Um alle Fähigkeiten zu durchlaufen und sie separat zu verarbeiten, kannst du eine Schleife verwenden
    foreach ($fähigkeiten as $fähigkeit) {
        // Verarbeite jede Fähigkeit hier, z.B. speichere sie in einer Datenbank oder führe andere Operationen durch
        echo "Fähigkeit: " . $fähigkeit . "<br>";
    }

    $conn = DBConnection::getConnection();

    try {
        // Die SQL-Abfrage vorbereiten
        $stmt = $conn->prepare("SELECT character_id FROM character WHERE First_Name = :firstname AND Last_Name = :lastname");
        // Parameter binden
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);

        // Die Abfrage ausführen
        $result = $stmt->execute();

        // Ergebnis abrufen
        $row = $result->fetchArray(SQLITE3_ASSOC);

        if ($result) {
            echo "Character ID: " . $row['character_id'];
            $characters_id = $row['character_id'];
        } else {
            echo "Kein Charakter mit diesem Namen gefunden.";
        }
    } catch (PDOException $e) {
        // Fehlerbehandlung, falls etwas schief geht
        echo "Datenbankfehler: " . $e->getMessage();
    }

    try {
        // Zuerst prüfen, ob ein Datensatz existiert
        $stmt = $conn->prepare("SELECT id FROM character_profile WHERE characters_id = :characters_id");
        $stmt->bindParam(':characters_id', $characters_id);
        $result = $stmt->execute();

        if ($result->fetchArray(SQLITE3_ASSOC)) {
            // Wenn ein Datensatz existiert, führe ein Update durch
            $updateStmt = $conn->prepare("UPDATE character_profile SET Nickname = :nickname, Age = :age, Race = :race, Birthday = :birthday, Gender = :gender, Height = :height, Weight = :weight WHERE characters_id = :characters_id");
            $updateStmt->bindParam(':characters_id', $characters_id);
            $updateStmt->bindParam(':nickname', $spitzname);
            $updateStmt->bindParam(':age', $alter);
            $updateStmt->bindParam(':race', $volk);
            $updateStmt->bindParam(':gender', $geschlecht);
            $updateStmt->bindParam(':height', $größe);
            $updateStmt->bindParam(':weight', $gewicht);
            $updateStmt->execute();
        
            echo "Datensatz aktualisiert.";
        } else {
            // Wenn kein Datensatz existiert, füge einen neuen hinzu
            $insertStmt = $conn->prepare("INSERT INTO character_profile (characters_id, Nickname, Age, Race, Gender, Height, Weight) VALUES (:characters_id, :nickname, :age, :race, :gender, :height, :weight)");
            $insertStmt->bindParam(':characters_id', $characters_id);
            $insertStmt->bindParam(':nickname', $spitzname);
            $insertStmt->bindParam(':age', $alter);
            $insertStmt->bindParam(':race', $volk);
            $insertStmt->bindParam(':gender', $geschlecht);
            $insertStmt->bindParam(':height', $größe);
            $insertStmt->bindParam(':weight', $gewicht);
            $insertStmt->execute();
            echo "Neuer Datensatz hinzugefügt.";
        }
    } catch (PDOException $e) {
        // Fehlerbehandlung
        echo "Datenbankfehler: " . $e->getMessage();
    }

    try {
        $stmt = $conn->prepare("SELECT id FROM character_personality WHERE character_id = :character_id");
        $stmt->bindParam(':character_id', $characters_id);
        $result = $stmt->execute();

        if ($result->fetchArray(SQLITE3_ASSOC)) {
            // Wenn ein Datensatz existiert, führe ein Update durch
            $updateStmt = $conn->prepare("UPDATE character_personality SET Likes = :likes, Dislikes = :dislikes, Personality = :personality, Background = :background WHERE character_id = :character_id");
            $updateStmt->bindParam(':character_id', $characters_id);
            $updateStmt->bindParam(':likes', $vorlieben);
            $updateStmt->bindParam(':dislikes', $abneigungen);
            $updateStmt->bindParam(':personality', $persönlichkeit);
            $updateStmt->bindParam(':background', $weiteres);
            $updateStmt->execute();
            echo "Datensatz aktualisiert.";
        } else {
            // Wenn kein Datensatz existiert, füge einen neuen hinzu
            $insertStmt = $conn->prepare("INSERT INTO character_personality (character_id, Likes, Dislikes, Personality, Background) VALUES (:character_id, :likes, :dislikes, :personality, :background)");
            $insertStmt->bindParam(':character_id', $characters_id);
            $insertStmt->bindParam(':likes', $vorlieben);
            $insertStmt->bindParam(':dislikes', $abneigungen);
            $insertStmt->bindParam(':personality', $persönlichkeit);
            $insertStmt->bindParam(':background', $weiteres);
            $insertStmt->execute();
            echo "Neuer Datensatz hinzugefügt.";
        }
    } catch (PDOException $e) {
        // Fehlerbehandlung
        echo "Datenbankfehler: " . $e->getMessage();
    }

    try {

        foreach ($fähigkeiten as $ability) {
            // Vorbereiten und Ausführen der SQL-Abfrage zum Einfügen eines Datensatzes
            $insertStmt = $conn->prepare("INSERT INTO character_ability (character_id, Description) VALUES (:character_id, :description)");
            $insertStmt->bindParam(':character_id', $characters_id);
            $insertStmt->bindParam(':description', $ability);
            $insertStmt->execute();
        }
    
        echo "Fähigkeiten erfolgreich hinzugefügt.";
    } catch (PDOException $e) {
        // Fehlerbehandlung
        echo "Datenbankfehler: " . $e->getMessage();
    }
}


?>