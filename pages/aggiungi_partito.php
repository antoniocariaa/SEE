<?php
include "connection.php";

// Verifica che il modulo sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["simbolo"]) && $_FILES["simbolo"]["error"] == UPLOAD_ERR_OK) {
    // Preleva i dati dal modulo
    $sigla = $_POST["sigla"];
    $nome = $_POST["nome"];

    // Carica l'immagine e convertila in base64
    $immagine = file_get_contents($_FILES["simbolo"]["tmp_name"]);
    $immagine_base64 = "data:image/png;base64,".base64_encode($immagine);

    // Prepara la query SQL
    $query = "INSERT INTO partito (sigla, nome, simbolo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Associa i dati del modulo alla query SQL
    $stmt->bind_param("sss", $sigla, $nome, $immagine_base64);

    // Esegui la query SQL
    $stmt->execute();

    // Chiudi la connessione al database
    $stmt->close();
    $conn->close();

    // Reindirizza l'utente alla pagina precedente
    header("Location: admin.php");
}
?>
