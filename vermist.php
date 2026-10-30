<?php
require 'db.php';

$fout = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = trim($_POST['item'] ?? '');
    $lost_time = trim($_POST['lost_time'] ?? '');
    $contact = trim($_POST['contact'] ?? '');

    if ($item !== '' && $lost_time !== '' && $contact !== '') {
        $stmt = $db->prepare(
                "INSERT INTO lost_items
            (item, lost_time, contact)
            VALUES (:item, :lost_time, :contact)"
        );

        $stmt->execute([
                ':item' => $item,
                ':lost_time' => $lost_time,
                ':contact' => $contact
        ]);

        header('Location: vermist.php?gelukt=1');
        exit;
    } else {
        $fout = 'Vul alle velden in.';
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voorwerp vermist melden</title>
    <link rel="stylesheet" href="vermist.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

    <h1>Voorwerp vermist melden</h1>
    <p>Ben je iets verloren? Vul hieronder je gegevens in.</p>

    <?php if (isset($_GET['gelukt'])): ?>
        <p class="gelukt">Je vermissing is succesvol gemeld!</p>
    <?php endif; ?>

    <?php if ($fout !== ''): ?>
        <p class="fout"><?= htmlspecialchars($fout) ?></p>
    <?php endif; ?>

    <form method="POST" action="vermist.php">

        <label for="item">Welk voorwerp ben je verloren?</label>
        <input
                type="text"
                id="item"
                name="item"
                placeholder="wat"
                required
        >

        <label for="lost_time">Wanneer ben je het verloren?</label>
        <input
                type="text"
                id="lost_time"
                name="lost_time"
                placeholder="wanneer"
                required
        >

        <label for="contact">Je contactgegevens</label>
        <input
                type="text"
                id="contact"
                name="contact"
                placeholder="contact"
                required
        >

        <button type="submit">Vermissing melden</button>

    </form>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
