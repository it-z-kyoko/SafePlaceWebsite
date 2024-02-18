<?php
function CreateDatabase() {
    $databaseFile = 'Database/SafePlace.db';

try {
    $db = new SQLite3($databaseFile);

    // characters Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS characters (
        character_id INTEGER PRIMARY KEY AUTOINCREMENT,
        First_Name TEXT,
        Last_Name TEXT,
        Player_id INTEGER,
        Posted DATE,
        Created DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (Player_id) REFERENCES players(id)
    )');

    // character_ability Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS character_ability (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        character_id INTEGER,
        Describtion TEXT NOT NULL,
        FOREIGN KEY (character_id) REFERENCES characters(character_id) ON DELETE CASCADE
    )');

    // character_family Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS character_family (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        character_id INTEGER,
        Parent1 INTEGER,
        Parent2 INTEGER,
        Grandparent1 INTEGER,
        Grandparent2 INTEGER,
        Grandparent3 INTEGER,
        Grandparent4 INTEGER,
        Sibling TEXT,
        Aunt TEXT,
        Uncle TEXT,
        Child TEXT,
        Partner INTEGER,
        Married INTEGER,
        FOREIGN KEY (character_id) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Parent1) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Parent2) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent1) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent2) REFERENCES characters(character_id) ON DELETE CASCADE,
        FOREIGN KEY (Grandparent3) REFERENCES characters(character_id),
        FOREIGN KEY (Grandparent4) REFERENCES characters(character_id),
        FOREIGN KEY (Partner) REFERENCES characters(character_id) ON DELETE CASCADE
    )');

    // character_personality Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS character_profiles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        characters_id INTEGER,
        Nickname TEXT,
        Age INTEGER,
        Race TEXT,
        Birthday DATE,
        Gender TEXT,
        Height INTEGER,
        Weight INTEGER,
        Child INTEGER,
        FOREIGN KEY (characters_id) REFERENCES characters(character_id) ON DELETE NO ACTION
    )');

    // character_profiles Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS players (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        Name TEXT NOT NULL,
        Birthday DATE,
        Last_Log_In DATE
    )');

    // players Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS tickets (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        Player_id INTEGER,
        Problem TEXT NOT NULL,
        Created DATETIME DEFAULT CURRENT_TIMESTAMP,
        Solved INTEGER NOT NULL DEFAULT 0,
        FOREIGN KEY (Player_id) REFERENCES players(id)
    )');

    // tickets Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS user (
        User_id INTEGER PRIMARY KEY AUTOINCREMENT,
        Player_id INTEGER,
        Username TEXT NOT NULL,
        Password TEXT NOT NULL,
        Last_login DATE NOT NULL,
        FOREIGN KEY (Player_id) REFERENCES players(id) ON DELETE CASCADE
    )');

    // user Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS wishlist (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        Player_id INTEGER,
        Describtion TEXT NOT NULL,
        FOREIGN KEY (Player_id) REFERENCES players(id)
    )');

    // wishlist Tabelle
    $db->exec('CREATE TABLE IF NOT EXISTS character_personality (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        character_id INTEGER UNIQUE,
        Likes TEXT,
        Dislikes TEXT,
        Personality TEXT,
        Background TEXT,
        FOREIGN KEY (character_id) REFERENCES characters(character_id) ON DELETE CASCADE
    )');
} catch (Exception $e) {
    die('Fehler beim Erstellen der Tabellen: ' . $e->getMessage());
}
}
?>