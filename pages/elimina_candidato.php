<?php
include "connection.php";

$id_candidato = $_POST['id_candidato'];

$query = "DELETE FROM candidato WHERE id_candidato=?";
$stmt = mysqli_prepare($conn, $query);

if($stmt){
    mysqli_stmt_bind_param($stmt, 'i', $id_candidato);
    mysqli_stmt_execute($stmt);

    header("Location: admin.php");
}
else{
    header("Location: admin.php?error=1");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
