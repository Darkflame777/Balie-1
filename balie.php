<?php


$db = new PDO("sqlite:lostandfound.db");

$db->exec("
    CREATE TABLE IF NOT EXISTS lost_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        item TEXT,
        lost_time TEXT,
        contact TEXT
    )
");


?>
<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lost and Found</title>
    <link rel="stylesheet" href="balie.css">
</head>
<body>


<div class="container">
    <header>
        <h1>lost and found</h1>
    </header>

    <section class="form-box">
        <h2>Nieuw item toevoegen</h2>

        <form id="itemForm">
            <div class="form-row">
                <input id="naam" type="text"
                       placeholder="Naam" required>

                <input id="categorie" type="text"
                       placeholder="Categorie" required>

                <input id="beschrijving" type="text"
                       placeholder="Beschrijving" required>
            </div>

            <button class="add" type="submit">
                versturen
            </button>
        </form>
    </section>
    <h2>Alle items</h2>
</body>
</html>
