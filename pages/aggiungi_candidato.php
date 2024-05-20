<?php
include "connection.php";

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$data_nascita = $_POST['data_nascita'];
$sesso = $_POST['sesso'];
$id_partito = $_POST['partito'];

$query = "INSERT INTO candidato (nome, cognome, data_nascita, sesso, id_partito) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if($stmt){
    mysqli_stmt_bind_param($stmt, 'sssss', $nome, $cognome, $data_nascita, $sesso, $id_partito);
    mysqli_stmt_execute($stmt);

    header("Location: admin.php");
}
else{
    echo 'Errore nella preparazione della query: ' . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
