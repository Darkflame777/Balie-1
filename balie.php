<?php

require 'db.php';
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
        <form action="opslaan.php" method="POST" id="itemForm">
            <div class="form-row">
                <input id="contact" name="contact" type="text"
                       placeholder="contact" required>

                <input id="lost_time" name="lost_time" type="text"
                       placeholder="tijd" required>

                <input id="item" name="item" type="text"
                       placeholder="item" required>
            </div>

            <button class="add" type="submit">
                versturen
            </button>
        </form>


    </section>
    <h2>Alle items</h2>
    <section class="items">
        <div class="itemsrow">
            <?php

            $statement = $db->query("SELECT * FROM lost_items");
            $items = $statement->fetchAll();

            foreach ($items as $item) {

                echo "<div class='echomaincontainer'>";
                echo "<div class='echomain'>";
                echo "<h2>Verloren voorwerp</h2>";
                echo "<p>item: " . $item["item"] . "</p>";
                echo "<p>tijd: " . $item["lost_time"] . "</p>";
                echo "<p>contact: " . $item["contact"] . "</p>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </section>
</body>
</html>
