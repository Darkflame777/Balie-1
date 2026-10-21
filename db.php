
<?php


$dbPad = __DIR__ . '/lostandfound.db';

if (!file_exists($dbPad)) {
    exit('Fout: databasebestand niet gevonden: ' . $dbPad);
}

$db = new PDO('sqlite:' . $dbPad);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

?>
