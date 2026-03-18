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

    // Elimina prima i candidati associati al partito per rispettare la chiave esterna (manca ON DELETE CASCADE)
    $query_candidati = "DELETE FROM candidato WHERE id_partito = ?";
    $stmt_candidati = $conn->prepare($query_candidati);
    $stmt_candidati->bind_param("s", $sigla);
    $stmt_candidati->execute();
    $stmt_candidati->close();

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
