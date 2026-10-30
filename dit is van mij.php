<?php
?>
<?php include("header.php"); ?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dit is van mij</title>

    <link rel="stylesheet" href="dit.css">
</head>

<body>

<nav class="navigatie">

</nav>

<div class="kaart">
    <h1>Dit is van mij</h1>

    <p>Onder kun je invullen welke spullen je kwijt bent geraakt.</p>
    <p>Deze spullen kunnen bij gevonden en vermist terechtkomen.</p>

    <form action="verwerken.php" method="POST">
        <h2>Over welke gevonden voorwerpen gaat het?</h2>
        <input type="text" id="voorwerp" name="voorwerp"
               placeholder="Vul hier in" required>

        <h2>Ik herken dit voorwerp aan</h2>
        <input type="text" id="herkenning" name="herkenning"
               placeholder="Vul hier in" required>

        <h2>Ik kan bewijzen dat dit voorwerp van mij is</h2>
        <input type="text" id="bewijs" name="bewijs"
               placeholder="Vul hier in" required>
        <?php
       echo "<button type='submit' class='delete-button'>Versturen!</button>";
        ?>
    </form>
</div>
<?php require 'footer.php'; ?>
</body>
</html>