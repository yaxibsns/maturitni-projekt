<?php

require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nazev = $_POST["title"];
    $castka = $_POST["amount"];
    $datum = $_POST["transaction_date"];
    $kategorie = $_POST["category_id"];

    $sql = "INSERT INTO transactions
            (title, amount, category_id, transaction_date)
            VALUES (?, ?, ?, ?)";

    $dotaz = mysqli_prepare($pripojeni, $sql);

    mysqli_stmt_bind_param(
        $dotaz,
        "sdis",
        $nazev,
        $castka,
        $kategorie,
        $datum
    );

    if (mysqli_stmt_execute($dotaz)) {
        echo "Záznam byl úspěšně přidán!";
    } else {
        echo "Chyba při ukládání záznamu.";
    }

    mysqli_stmt_close($dotaz);
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přidat záznam</title>
</head>
<body>

    <h1>Přidat nový záznam</h1>

    <form method="POST">

        <label>Název záznamu:</label><br>
        <input type="text" name="title" required>
        <br><br>

        <label>Částka:</label><br>
        <input type="number" name="amount" step="0.01" required>
        <br><br>

        <label>Datum:</label><br>
        <input type="date" name="transaction_date" required>
        <br><br>

        <label>Kategorie:</label><br>
        <select name="category_id" required>
            <option value="1">Prodej služeb</option>
            <option value="2">Reklamy</option>
            <option value="3">Doprava</option>
            <option value="4">Nájem</option>
            <option value="5">Materiál</option>
        </select>
        <br><br>

        <button type="submit">Přidat záznam</button>

    </form>

</body>
</html>