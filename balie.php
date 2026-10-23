

<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['delete_id'])) {

    $id = filter_var(
            $_POST['delete_id'],
            FILTER_VALIDATE_INT
    );

    if ($id !== false && $id !== null && $id > 0) {
        $stmt = $db->prepare(
                "DELETE FROM lost_items WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
    }

    header('Location: balie.php');
    exit;
}
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
$items = $statement->fetchAll(PDO::FETCH_ASSOC);


foreach ($items as $item) {
    $id = (int) $item['id'];

    $naam = htmlspecialchars($item['item'], ENT_QUOTES, 'UTF-8');
    $tijd = htmlspecialchars($item['lost_time'], ENT_QUOTES, 'UTF-8');
    $contact = htmlspecialchars($item['contact'], ENT_QUOTES, 'UTF-8');

    echo "<div class='echomaincontainer'>";

    echo "<input type='checkbox' class='popup-toggle' id='popup-$id'>";

    echo "<label class='echomain' for='popup-$id'>";
    echo "<h2>$naam</h2>";
    echo "<p>Tijd: $tijd</p>";
    echo "<span class='bekijk-label'>Klik voor meer informatie</span>";
    echo "</label>";

    echo "<div class='popup-overlay'>";

    echo "<div class='popup-content'>";

    echo "<h2>$naam</h2>";
    echo "<p><strong>Item:</strong> $naam</p>";
    echo "<p><strong>Tijd:</strong> $tijd</p>";
    echo "<p><strong>Contact:</strong> $contact</p>";

    echo "<form method='POST' action='verwijderen.php'>";

    echo "<input type='hidden' name='delete_id' value='$id'>";

    echo "<button type='submit' class='delete-button'>
        Verwijder item
    </button>";

    echo "</form>";

    echo "<label class='popup-close' for='popup-$id'>Sluiten ×</label>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
}
?>


        </div>
    </section>
    <?php require 'footer.php'; ?>

</body>
</html>
