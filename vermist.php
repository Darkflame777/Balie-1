<?php
?>
<?php include("header.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="vermist.css"
</head>
<body>
<section class="form-box">
<form id="itemform">
    <div class="form-row">
    <input type="text" id="item" placeholder="item" checked>
    <input type="text" id="contact" placeholder="contact">
    <input type="text" id="tijd" placeholder="tijd">
    </div>
    <button class="add" type="submit">
        Versturen
    </button>
</form>
</section>
<?php require 'footer.php'; ?>
</body>
</html>
