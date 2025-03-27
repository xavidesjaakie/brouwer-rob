<?php
// Functie: update brouwer
// Auteur: Vul hier je naam in

require_once('functions.php');

// Controle of er een wijziging is ingediend
if (isset($_POST['btn_wzg'])) {
    if (!isset($_POST['brouwcode']) || empty($_POST['brouwcode'])) {
        die("Fout: Geen brouwcode opgegeven bij de update.");
    }

    if (updateRecord($_POST)) {
        echo "<script>alert('Brouwer is gewijzigd'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Brouwer is NIET gewijzigd');</script>";
    }
}

// Controleer of er een brouwcode in de URL staat
if (!isset($_GET['brouwcode']) || empty($_GET['brouwcode'])) {
    die("Fout: Geen brouwcode opgegeven.");
}

$brouwcode = $_GET['brouwcode'];
$record = getRecord($brouwcode);

if (!$record) {
    die("Fout: Geen gegevens gevonden voor deze brouwcode.");
}

// Vul de variabelen met de bestaande waarden
$naam = htmlspecialchars($record['naam'] ?? '');
$land = htmlspecialchars($record['land'] ?? '');

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Wijzig Brouwer</title>
</head>
<body>

<h2>Wijzig Brouwer</h2>

<form method="POST" action="update.php">
    <input type="hidden" name="brouwcode" value="<?= $brouwcode ?>">

    <label>Naam:</label>
    <input type="text" name="naam" value="<?= $naam ?>" required>
    
    <label>Land:</label>
    <input type="text" name="land" value="<?= $land ?>" required>
    
    <button type="submit" name="btn_wzg">Wijzig</button>
</form>

<br><br>
<a href='index.php'>Home</a>

</body>
</html>
