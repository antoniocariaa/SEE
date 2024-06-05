<?php
include "connection.php";

// Verifica che il modulo sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati dal modulo
    $id_seggio = $_POST["id_seggio"];
    $indirizzo = $_POST["indirizzo"];

    // Prepara la query SQL per aggiornare la sigla e il nome del partito
    $query = "UPDATE seggio SET indirizzo = ? WHERE id_seggio = ?";
    $stmt = $conn->prepare($query);

    // Associa i dati del modulo alla query SQL
    $stmt->bind_param("si", $indirizzo, $id_seggio);

    // Esegui la query SQL
    $stmt->execute();

    // Chiudi la connessione al database
    $stmt->close();
    $conn->close();

    // Reindirizza l'utente alla pagina precedente
    header("Location: admin.php");
}
?>
