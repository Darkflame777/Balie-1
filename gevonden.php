<?php
require 'db.php';

$fout = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = trim($_POST['item']);
    $lost_time = trim($_POST['lost_time']);
    $contact = trim($_POST['contact']);
    $herkenning = trim($_POST['herkenning']);

    if (
            $item === '' ||
            $lost_time === '' ||
            $contact === '' ||
            $herkenning === '' ||
            empty($_FILES['foto']['name'])
    ) {
        $fout = 'Vul alles in en voeg een foto toe.';
    } elseif ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        $fout = 'De foto kon niet worden geüpload.';
    } elseif ($_FILES['foto']['size'] > 5 * 1024 * 1024) {
        $fout = 'De foto mag maximaal 5 MB zijn.';
    } else {
        $tijdelijkBestand = $_FILES['foto']['tmp_name'];
        $mimeType = mime_content_type($tijdelijkBestand);

        $toegestaneTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
        ];

        if (!isset($toegestaneTypes[$mimeType])) {
            $fout = 'Gebruik een JPG-, PNG- of WEBP-foto.';
        } else {
            $map = 'uploads/';

            if (!is_dir($map)) {
                mkdir($map, 0755, true);
            }

            $bestandsnaam = bin2hex(random_bytes(16)) . '.' . $toegestaneTypes[$mimeType];
            $fotoPad = $map . $bestandsnaam;

            if (move_uploaded_file($tijdelijkBestand, $fotoPad)) {
                $stmt = $db->prepare("
                    INSERT INTO lost_items
                    (item, lost_time, contact, status, voorwerp_status, foto, herkenning)
                    VALUES (?, ?, ?, 'Gemeld', 'Gevonden', ?, ?)
                ");

                $stmt->execute([
                        $item,
                        $lost_time,
                        $contact,
                        $fotoPad,
                        $herkenning
                ]);

                header('Location: gevonden.php?gelukt=1');
                exit;
            } else {
                $fout = 'De foto kon niet worden opgeslagen.';
            }
        }
    }
}
?>

<?php require 'header.php'; ?>

    <link rel="stylesheet" href="gevonden.css">

    <main class="gevonden-container">
        <h1>Gevonden voorwerp aanmelden</h1>
        <p>Vul de gegevens in en voeg een foto toe.</p>

        <?php if (isset($_GET['gelukt'])): ?>
            <p class="succes">Het gevonden voorwerp is aangemeld!</p>
        <?php endif; ?>

        <?php if ($fout !== ''): ?>
            <p class="fout"><?= htmlspecialchars($fout) ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Welk voorwerp heb je gevonden?</label>
            <input type="text" name="item" required>

            <label>Wanneer heb je het gevonden?</label>
            <input type="datetime-local" name="lost_time" required>

            <label>Jouw contactgegevens</label>
            <input type="text" name="contact" placeholder="E-mail of telefoonnummer" required>

            <label>Foto van het gevonden voorwerp</label>
            <input type="file" name="foto" accept="image/jpeg,image/png,image/webp" required>

            <label>Bijzonderheden of herkenningspunten</label>
            <textarea name="herkenning" placeholder="Beschrijf bijvoorbeeld kleur, merk of opvallende kenmerken." required></textarea>

            <button type="submit">Voorwerp aanmelden</button>
        </form>
    </main>

<?php require 'footer.php'; ?>

