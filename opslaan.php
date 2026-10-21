
<?php

require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Open balie.php en verstuur het formulier.');
}

$item = trim($_POST['item'] ?? '');
$lost_time = trim($_POST['lost_time'] ?? '');
$contact = trim($_POST['contact'] ?? '');

if ($item === '' || $lost_time === '' || $contact === '') {
    exit('Fout: niet alle formuliergegevens zijn ontvangen.');
}

try {
    $stmt = $db->prepare(
        'INSERT INTO lost_items (item, lost_time, contact)
         VALUES (:item, :lost_time, :contact)'
    );

    $stmt->execute([
        ':item' => $item,
        ':lost_time' => $lost_time,
        ':contact' => $contact
    ]);

    header('Location: balie.php?opgeslagen=1');
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Fout bij opslaan. Controleer de PHP-errorlog.');
}
?>
