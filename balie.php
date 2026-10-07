<?php ?>
<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>balie</title>
    <link rel="stylesheet" href="balie.css">
</head>
<body>
<main>
    <section>
        <div class="containerform">
            <from action="#" method="post">
                <div class="vermist">
                    <h2 class="title">dit ben ik kwijt</h2>
                    <label for="wat ben je kwijt">wat ben je kwijt</label>

                    <input

                        type="text"
                        id="wat ben je kwijt"
                        name="wat ben je kwijt"
                        placeholder="wat ben je kwijt"
                        required
                    >
                </div>
                <div class="vermist">
                    <h2 class="title">waar ben je het verloren</h2>
                    <label for="waar ben je het verloren">waar ben je het verloren</label>

                    <input

                        type="text"
                        id="waar ben je het verloren"
                        name="waar ben je het verloren"
                        placeholder="waar ben je het verloren"
                        required
                    >
                </div>
                <button type="submit" class="knop">
                    verzenden
                </button>
            </from>
        </div>
    </section>
</main>
</body>
</html>
