<?php
require 'db.php';

// Maak de tabel aan als deze nog niet bestaat.
$db->exec("CREATE TABLE IF NOT EXISTS found_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    naam TEXT NOT NULL,
    locatie TEXT NOT NULL,
    datum TEXT NOT NULL,
    contact TEXT NOT NULL,
    foto_url TEXT,
    aangemaakt_op TEXT DEFAULT CURRENT_TIMESTAMP
)");

$fout = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $locatie = trim($_POST['locatie'] ?? '');
    $datum = trim($_POST['datum'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $fotoUrl = trim($_POST['foto_url'] ?? '');

    if ($naam === '' || $locatie === '' || $datum === '' || $contact === '') {
        $fout = 'Vul alle verplichte velden in.';
    } elseif ($fotoUrl !== '' && !filter_var($fotoUrl, FILTER_VALIDATE_URL)) {
        $fout = 'Vul een geldige foto-URL in of laat dit veld leeg.';
    } else {
        $query = $db->prepare('INSERT INTO found_items (naam, locatie, datum, contact, foto_url) VALUES (:naam, :locatie, :datum, :contact, :foto_url)');
        $query->execute([
                ':naam' => $naam,
                ':locatie' => $locatie,
                ':datum' => $datum,
                ':contact' => $contact,
                ':foto_url' => $fotoUrl !== '' ? $fotoUrl : null
        ]);
        $succes = 'De gevonden vondst is opgeslagen.';
    }
}

$zoek = trim($_GET['zoek'] ?? '');

$sql = "SELECT * FROM found_items
        WHERE naam LIKE :zoek OR locatie LIKE :zoek
        ORDER BY datum DESC, id DESC";
$query = $db->prepare($sql);
$query->execute([':zoek' => '%' . $zoek . '%']);
$gevondenItems = $query->fetchAll(PDO::FETCH_ASSOC);

function veilig($waarde): string
{
    return htmlspecialchars((string)($waarde ?? ''), ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gevonden - Lost and Found</title>
    <link rel="stylesheet" href="balie.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="gevonden.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
    <header>
        <h1>Gevonden voorwerpen</h1>
    </header>

    <section class="form-box">
        <h2>Een gevonden voorwerp melden</h2>
        <p>Heb je iets gevonden? Vul het formulier in, zodat de eigenaar het terug kan vinden.</p>

        <?php if ($fout !== ''): ?>
            <p class="melding fout" role="alert"><?php echo veilig($fout); ?></p>
        <?php endif; ?>
        <?php if ($succes !== ''): ?>
            <p class="melding succes" role="status"><?php echo veilig($succes); ?></p>
        <?php endif; ?>

        <form method="post" action="gevonden.php">
            <div class="form-row">
                <label>
                    Wat heb je gevonden? *
                    <input type="text" name="naam" placeholder="Bijvoorbeeld: sleutelbos" required maxlength="100" value="<?php echo veilig($_POST['naam'] ?? ''); ?>">
                </label>
                <label>
                    Waar gevonden? *
                    <input type="text" name="locatie" placeholder="Bijvoorbeeld: in de aula" required maxlength="150" value="<?php echo veilig($_POST['locatie'] ?? ''); ?>">
                </label>
                <0label>
                    Wanneer gevonden? *
                    <input type="date" name="datum" required value="<?php echo veilig($_POST['datum'] ?? ''); ?>">
                </0label>
                <label>
                    Contactgegevens *
                    <input type="text" name="contact" placeholder="E-mail of telefoonnummer" required maxlength="150" value="<?php echo veilig($_POST['contact'] ?? ''); ?>">
                </label>
                <label>
                    Foto-URL (optioneel)
                    <input type="url" name="foto_url" placeholder="https://voorbeeld.nl/foto.jpg" value="<?php echo veilig($_POST['foto_url'] ?? ''); ?>">
                </label>
            </div>
            <button class="add" type="submit">Vondst melden</button>
        </form>
    </section>

    <h2>Gemelde gevonden voorwerpen</h2>

    <form class="zoek-form" method="get" action="gevonden.php">
        <input type="search" name="zoek" placeholder="Zoek op voorwerp of vindplaats..."
               value="<?php echo veilig($zoek); ?>" aria-label="Zoek gevonden voorwerpen">
        <button type="submit">Zoeken</button>*6921
*9
        <?php if ($zoek !== ''): ?>
            <a class="wis-zoek" href="gevonden.php">Wis zoekopdracht</a>
        <?php endif; ?>
    </form>

    <p class="datum-uitleg">Nieuwste vondsten staan bovenaan.</p>
    <section class="items gevonden-lijst">
        <?php if (count($gevondenItems) === 0): ?>
            <p><?php echo $zoek !== '' ? 'Geen gevonden voorwerpen gevonden voor deze zoekopdracht.' : 'Er zijn nog geen gevonden voorwerpen gemeld.'; ?></p>
        <?php else: ?>
            <div class="gevonden-grid">
                <?php foreach ($gevondenItems as $item): ?>
                    <article class="gevonden-kaart">
                        <?php if (!empty($item['foto_url'])): ?>
                            <img class="gevonden-foto" src="<?php echo veilig($item['foto_url']); ?>" alt="Foto van <?php echo veilig($item['naam']); ?>" loading="lazy">
                        <?php endif; ?>
                        <h3><?php echo veilig($item['naam']); ?></h3>
                        <p><strong>Locatie:</strong> <?php echo veilig($item['locatie']); ?></p>
                        <p><strong>Datum:</strong> <?php echo veilig($item['datum']); ?></p>
                        <p><strong>Contact:</strong> <?php echo veilig($item['contact']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
