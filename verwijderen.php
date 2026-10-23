
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: balie.php');
    exit;
}

$id = filter_input(INPUT_POST, 'delete_id', FILTER_VALIDATE_INT);

if ($id !== false && $id !== null && $id > 0) {
    $stmt = $db->prepare(
        'DELETE FROM lost_items WHERE id = :id'
    );
    $stmt->execute([':id' => $id]);
}

header('Location: balie.php');
exit;
?>
<?php
