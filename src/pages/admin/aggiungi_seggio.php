<?php
include "../../includes/connection.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo"] !== "a") {
    header("Location: ../../index.php");
    exit;
}

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Invalid CSRF token");
}


// Verifica che il modulo sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati dal modulo
    $indirizzo = $_POST["indirizzo"];

    // Prepara la query SQL
    $query = "INSERT INTO seggio (indirizzo) VALUES (?)";
    $stmt = $conn->prepare($query);

    // Associa i dati del modulo alla query SQL
    $stmt->bind_param("s", $indirizzo);

    // Esegui la query SQL
    $stmt->execute();

    // Chiudi la connessione al database
    $stmt->close();
    $conn->close();

    // Reindirizza l'utente alla pagina precedente
    header("Location: admin.php");
}
?>
