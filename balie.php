<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status_aanpassen'])) {
    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
    $status = $_POST['status'] ?? '';
    $voorwerp_status = $_POST['voorwerp_status'] ?? '';

    if (
            $id > 0 &&
            in_array($status, ['Gemeld', 'Meegegeven', 'Afgewezen'], true) &&
            in_array($voorwerp_status, ['Nog verloren', 'Gevonden'], true)
    ) {
        $stmt = $db->prepare(
                "UPDATE lost_items
             SET status = :status, voorwerp_status = :voorwerp_status
             WHERE id = :id"
        );

        $stmt->execute([
                ':status' => $status,
                ':voorwerp_status' => $voorwerp_status,
                ':id' => $id
        ]);
    }

    header('Location: balie.php');
    exit;
}

$stmt = $db->query("SELECT * FROM lost_items ORDER BY id DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

function toonItems($items)
{
    if (count($items) === 0) {
        echo '<p>Geen voorwerpen gevonden.</p>';
        return;
    }

    foreach ($items as $item) {
        $id = (int) $item['id'];
        $naam = htmlspecialchars($item['item'] ?? '', ENT_QUOTES, 'UTF-8');
        $tijd = htmlspecialchars($item['lost_time'] ?? '', ENT_QUOTES, 'UTF-8');
        $contact = htmlspecialchars($item['contact'] ?? '', ENT_QUOTES, 'UTF-8');
        $status = $item['status'] ?? 'Gemeld';
        $voorwerp = $item['voorwerp_status'] ?? 'Nog verloren';
        ?>

        <div class="kaart">
            <h3><?= $naam ?></h3>

            <p><strong>Tijd:</strong> <?= $tijd ?></p>
            <p><strong>Contact:</strong> <?= $contact ?></p>
            <p><strong>Melding:</strong>
                <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>
            </p>
            <p><strong>Voorwerp:</strong>
                <?= htmlspecialchars($voorwerp, ENT_QUOTES, 'UTF-8') ?>
            </p>

            <form method="post" action="balie.php">
                <input type="hidden" name="id" value="<?= $id ?>">

                <label for="status-<?= $id ?>">Status melding</label>
                <select name="status" id="status-<?= $id ?>">
                    <?php foreach (['Gemeld', 'Meegegeven', 'Afgewezen'] as $keuze): ?>
                        <option value="<?= $keuze ?>"
                                <?= $status === $keuze ? 'selected' : '' ?>>
                            <?= $keuze ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="voorwerp-<?= $id ?>">Status voorwerp</label>
                <select name="voorwerp_status" id="voorwerp-<?= $id ?>">
                    <?php foreach (['Nog verloren', 'Gevonden'] as $keuze): ?>
                        <option value="<?= $keuze ?>"
                                <?= $voorwerp === $keuze ? 'selected' : '' ?>>
                            <?= $keuze ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="status_aanpassen" value="1">
                    Opslaan
                </button>
            </form>

            <form method="post" action="verwijderen.php">
                <input type="hidden" name="delete_id" value="<?= $id ?>">
                <button type="submit" class="verwijderen">
                    Verwijderen
                </button>
            </form>
        </div>

        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Balie - Lost and Found</title>
    <link rel="stylesheet" href="balie.css">
</head>
<body>

<?php include 'header.php'; ?>

<main class="container">
    <h1>Balie</h1>

    <section>
        <h2>Nog vermist</h2>
        <div class="items">
            <?php
            $vermist = array_filter($items, function ($item) {
                return ($item['voorwerp_status'] ?? 'Nog verloren') === 'Nog verloren'
                        && ($item['status'] ?? 'Gemeld') !== 'Afgewezen';
            });
            toonItems(array_values($vermist));
            ?>
        </div>
    </section>

    <section>
        <h2>Matches / gevonden voorwerpen</h2>
        <div class="items">
            <?php
            $gevonden = array_filter($items, function ($item) {
                return ($item['voorwerp_status'] ?? 'Nog verloren') === 'Gevonden';
            });
            toonItems(array_values($gevonden));
            ?>
        </div>
    </section>

    <section>
        <h2>Alle meldingen</h2>
        <div class="items">
            <?php toonItems($items); ?>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
