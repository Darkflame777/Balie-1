
<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Lost and Found</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

<div class="container">

    <div class="welkom">
        <h1>Welkom bij Lost and Found</h1>

        <p>
            Ben je iets kwijtgeraakt of heb je iets gevonden?
            Op deze website kun je verloren en gevonden
            voorwerpen aanmelden en bekijken.
        </p>

        <a href="balie.php" class="knop">
            Bekijk alle voorwerpen
        </a>
    </div>

    <h2>Wat wil je doen?</h2>

    <div class="opties">

        <div class="kaart">
            <h3>Voorwerp verloren?</h3>

            <p>
                Ben je iets kwijt? Meld het voorwerp aan,
                zodat anderen kunnen helpen het terug te vinden.
            </p>

            <a href="vermist.php">Verloren voorwerp aanmelden</a>
        </div>

        <div class="kaart">
            <h3>Voorwerp gevonden?</h3>

            <p>
                Heb je iets gevonden? Meld het voorwerp aan,
                zodat de eigenaar het kan terugvinden.
            </p>

            <a href="gevonden.php">Gevonden voorwerp aanmelden</a>
        </div>

    </div>

    <h2>Hoe werkt het?</h2>

    <div class="uitleg">
        <p><strong>1.</strong> Meld een verloren of gevonden voorwerp aan.</p>

        <p><strong>2.</strong> Bekijk de aangemelde voorwerpen op de website.</p>

        <p><strong>3.</strong> Neem contact op om het voorwerp terug te krijgen.</p>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
