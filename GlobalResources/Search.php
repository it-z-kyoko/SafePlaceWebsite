<?php
include_once("../../Classes/DBConnection.php");
$searching = $_GET['id'];

// Datenbankverbindung herstellen
$conn = DBConnection::getConnection();

// SQL-Abfrage für den gewünschten Datensatz
$sql = "SELECT * FROM character_family WHERE character_id = $searching";
$result = $conn->query($sql);

// Überprüfen, ob ein Datensatz gefunden wurde
if ($result) {
    $row = $result->fetchArray(SQLITE3_ASSOC);
}
?>

<style>
    #popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        z-index: 1000;
        height: 80%;
        width: 20%;
        overflow: scroll;
        background-color: #1a1a1a;
        color: #fff;
    }

    #closePopup {
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    #closePopup:hover {
        color: #555;
        /* Textfarbe bei Hover anpassen */
    }

    ::-webkit-scrollbar {
        width: 12px;
        /* Breite der Scrollbar */
    }

    ::-webkit-scrollbar-thumb {
        background-color: #888;
        /* Farbe des Scrollbar-Griffs */
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #555;
        /* Farbe des Scrollbar-Griffs bei Hover */
    }

    /* Media Query for responsive adjustments */
    @media only screen and (max-width: 768px) {
        #popup {
            width: 90%;
        }
    }
</style>

<button id="openPopup">Nach Id suchen</button>
<!-- Das Pop-Up-Fenster -->
<div id="popup">
    <span id="closePopup">X</span>
    <input type="text" id="searchInput" placeholder="Nach Vorname suchen">
    <table id="dataTable">
        <!-- Hier werden die Daten dynamisch eingefügt -->
    </table>
</div>

<script>
    document.getElementById('openPopup').addEventListener('click', function() {
        // Pop-Up anzeigen
        document.getElementById('popup').style.display = 'block';

        // Fetch data from the server TODO: Pfad Ändern
        fetch('deine-daten-abruf-datei.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Hier den Textinhalt der Antwort erhalten
            })
            .then(text => {
                // Hier isolieren wir den JSON-Teil des Textinhalts
                const jsonStartIndex = text.indexOf("[");
                const jsonString = text.substring(jsonStartIndex); // JSON-Teil isolieren
                return JSON.parse(jsonString); // JSON-String parsen
            })
            .then(data => updateDataTable(data))
            .catch(error => console.error('Fetch error:', error));

    });

    document.getElementById('closePopup').addEventListener('click', function() {
        // Pop-Up ausblenden
        document.getElementById('popup').style.display = 'none';
    });



    document.getElementById('searchInput').addEventListener('input', function() {
        // Wert des searchInput-Feldes abrufen
        var searchTerm = this.value.toLowerCase();

        // Filterfunktion aufrufen
        filterDataTable(searchTerm);
    });

    function filterDataTable(searchTerm) {
        // Tabelle abrufen
        var table = document.getElementById('dataTable');

        // Alle Zeilen der Tabelle durchgehen (beginnend ab Index 1, da Index 0 die Überschriften sind)
        for (var i = 1; i < table.rows.length; i++) {
            var row = table.rows[i];

            // Den Vornamen in der aktuellen Zeile abrufen (nehmen wir an, dass der Vornamen in der zweiten Zelle ist)
            var firstName = row.cells[1].textContent.toLowerCase();

            // Überprüfen, ob der Vornamen den Suchbegriff enthält
            if (firstName.includes(searchTerm)) {
                // Wenn der Vornamen den Suchbegriff enthält, die Zeile anzeigen
                row.style.display = '';
            } else {
                // Andernfalls die Zeile ausblenden
                row.style.display = 'none';
            }
        }
    }


    function updateDataTable(data) {
        console.log(data);
        var dataTable = document.getElementById('dataTable');
        dataTable.innerHTML = ''; // Tabelle leeren

        // Tabellenkopf hinzufügen
        var tableHeader = dataTable.createTHead();
        var headerRow = tableHeader.insertRow(0);
        headerRow.insertCell(0).innerHTML = '<b>ID</b>';
        headerRow.insertCell(1).innerHTML = '<b>Vorname</b>';
        headerRow.insertCell(2).innerHTML = '<b>Nachname</b>';

        // Datenzeilen hinzufügen
        for (var i = 0; i < data.length; i++) {
            var row = dataTable.insertRow(i + 1);
            row.insertCell(0).innerHTML = data[i].character_id;
            row.insertCell(1).innerHTML = data[i].First_Name;
            row.insertCell(2).innerHTML = data[i].Last_Name;
        }
    }
</script>

</html>