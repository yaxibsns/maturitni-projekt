<?php

$server = "localhost";
$uzivatel = "root";
$heslo = "";
$databaze = "evidence_osvc";

$pripojeni = mysqli_connect($server, $uzivatel, $heslo, $databaze);

if (!$pripojeni) {
    die("Nepodařilo se připojit k databázi.");
}

mysqli_set_charset($pripojeni, "utf8mb4");

?>