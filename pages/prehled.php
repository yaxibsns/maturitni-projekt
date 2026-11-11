<?php

require "../config/database.php";


$sql = "SELECT 
    transactions.title,
    transactions.amount,
    transactions.transaction_date,
    categories.name AS category_name,
    categories.type AS category_type
    FROM transactions
    JOIN categories
    ON transactions.category_id = categories.id
    ORDER BY transactions.transaction_date DESC";

$vysledek = mysqli_query($pripojeni, $sql);

$sql_prijmy = "SELECT SUM(transactions.amount) AS celkem
FROM transactions
JOIN categories ON transactions.category_id = categories.id
WHERE categories.type = 'income'";

$vysledek_prijmy = mysqli_query($pripojeni, $sql_prijmy);
$radek_prijmy = mysqli_fetch_assoc($vysledek_prijmy);

$celkove_prijmy = $radek_prijmy["celkem"];


$sql_vydaje = "SELECT SUM(transactions.amount) AS celkem
FROM transactions
JOIN categories ON transactions.category_id = categories.id
WHERE categories.type = 'expense'";

$vysledek_vydaje = mysqli_query($pripojeni, $sql_vydaje);
$radek_vydaje = mysqli_fetch_assoc($vysledek_vydaje);

$celkove_vydaje = $radek_vydaje["celkem"];


$zustatek = $celkove_prijmy - $celkove_vydaje;

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přehled příjmů a výdajů</title>
    <h2>Finanční přehled</h2>

<p>Celkové příjmy: <?php echo $celkove_prijmy; ?> Kč</p>

<p>Celkové výdaje: <?php echo $celkove_vydaje; ?> Kč</p>

<p>Zůstatek: <?php echo $zustatek; ?> Kč</p>
</head>
<body>

    <h1>Přehled příjmů a výdajů</h1>

    <table border="1">
    <tr>
        <th>Název</th>
        <th>Částka</th>
        <th>Datum</th>
        <th>Kategorie</th>
        <th>Druh</th>
    </tr>

    <?php while ($zaznam = mysqli_fetch_assoc($vysledek)) { ?>

        <tr>
            <td><?php echo $zaznam["title"]; ?></td>
            <td><?php echo $zaznam["amount"]; ?> Kč</td>
            <td><?php echo $zaznam["transaction_date"]; ?></td>
            <td><?php echo $zaznam["category_name"]; ?></td>
            <td>
    <?php
    if ($zaznam["category_type"] == "income") {
        echo "Příjem";
    } else {
        echo "Výdaj";
    }
    ?>
</td>
        </tr>

    <?php } ?>
</table>

        <?php while ($zaznam = mysqli_fetch_assoc($vysledek)) { ?>

            <tr>
                <td><?php echo $zaznam["title"]; ?></td>
                <td><?php echo $zaznam["amount"]; ?> Kč</td>
                <td><?php echo $zaznam["transaction_date"]; ?></td>
            </tr>

        <?php } ?>

    </table>

</body>
</html>