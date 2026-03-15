<?php
include "../../../includes/connection.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo"] !== "a") {
    header("Location: ../../../public/index.php");
    exit;
}

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Invalid CSRF token");
}


// Verifica che il modulo sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preleva i dati dal modulo
    $sigla = $_POST["sigla"];
    $nome = $_POST["nome"];

    // Se è stato caricato un nuovo simbolo, convertilo in base64 e aggiornalo nel database
    if (isset($_FILES["simbolo"]) && $_FILES["simbolo"]["error"] == UPLOAD_ERR_OK) {
        $immagine = file_get_contents($_FILES["simbolo"]["tmp_name"]);
        $immagine_base64 = "data:image/png;base64,".base64_encode($immagine);

        // Prepara la query SQL
        $query = "UPDATE partito SET simbolo = ? WHERE sigla = ?";
        $stmt = $conn->prepare($query);

        // Associa i dati del modulo alla query SQL
        $stmt->bind_param("ss", $immagine_base64, $sigla);

        // Esegui la query SQL
        $stmt->execute();

        // Chiudi la connessione al database
        $stmt->close();
    }

    // Prepara la query SQL per aggiornare la sigla e il nome del partito
    $query = "UPDATE partito SET sigla = ?, nome = ? WHERE sigla = ?";
    $stmt = $conn->prepare($query);

    // Associa i dati del modulo alla query SQL
    $stmt->bind_param("sss", $sigla, $nome, $sigla);

    // Esegui la query SQL
    $stmt->execute();

    // Chiudi la connessione al database
    $stmt->close();
    $conn->close();

    // Reindirizza l'utente alla pagina precedente
    header("Location: admin.php");
}
?>
