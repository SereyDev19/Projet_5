<?php
$host_name = 'db5000279850.hosting-data.io';
$database = 'dbs273161';
$user_name = 'dbu387161';
$password = 'Bddreportme1987!';
$dbh = null;


try {
    $dbh = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
} catch (PDOException $e) {
    echo "Erreur!: " . $e->getMessage() . "<br/>";
    die();
}
?>
