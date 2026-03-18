<?php
include "../../../includes/connection.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo"] !== "a") {
    header("Location: ../../../public/index.php");
    exit;
}

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Invalid CSRF token");
}


$id_candidato = $_POST['id_candidato'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$data_nascita = $_POST['data_nascita'];
$sesso = $_POST['sesso'];
$id_partito = $_POST['partito'];

$query = "UPDATE candidato SET nome=?, cognome=?, data_nascita=?, sesso=?, id_partito=? WHERE id_candidato=?";
$stmt = mysqli_prepare($conn, $query);

if($stmt){
    mysqli_stmt_bind_param($stmt, 'sssssi', $nome, $cognome, $data_nascita, $sesso, $id_partito, $id_candidato);
    mysqli_stmt_execute($stmt);

    header("Location: admin.php");
}
else{
    header("Location: admin.php?error=1");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
