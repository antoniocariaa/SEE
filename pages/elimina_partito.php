<?php
include "connection.php";

// Verifica che il modulo sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati dal modulo
    $sigla = $_POST["sigla"];

    // Prepara la query SQL
    $query = "DELETE FROM partito WHERE sigla = ?";
    $stmt = $conn->prepare($query);

    // Associa i dati del modulo alla query SQL
    $stmt->bind_param("s", $sigla);

    // Esegui la query SQL
    $stmt->execute();

    // Chiudi la connessione al database
    $stmt->close();
    $conn->close();

    // Reindirizza l'utente alla pagina precedente
    header("Location: admin.php");
}
?>
