<?php

    session_start();
    if(isset($_SESSION["id"])){
        header("Location: vota.php");
    }

    include "connection.php";
    $codice_tessera = $_POST["codice_tessera"];
    $password = $_POST["password"];
    if(isset($_POST["codice_documento"])){
        $codice_documento = $_POST["codice_documento"];
    }
    if(isset($_POST["tipo_documento"])){
        $tipo_documento = $_POST["tipo_documento"];
    }
    if(isset($_POST["codice_patente"])){
        $codice_patente = $_POST["codice_patente"];
    }
    if(isset($_POST["codice_identita"])){
        $codice_identita = $_POST["codice_identita"];
    }
    if(isset($_POST["seggio"])){
        $seggio = $_POST["seggio"];
    }

    if(isset($tipo_documento)){
        login();
    } else {
        $sql = "insert into elettore (codice_tessera_elettorale, codice_carta_identita, codice_patente, password, id_seggio) values (?, ?, ?, SHA1(?), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $codice_tessera, $codice_identita, $codice_patente, $password, $seggio);

        $stmt->execute();

        $tipo_documento = "carta_identita";
        $codice_documento = $codice_identita;

        login();
    }


    //funzione di login

    function login(){

        global $conn, $codice_tessera, $password, $codice_documento, $tipo_documento;

        if($tipo_documento == "carta_identita"){

            //query con bind_param
            $sql = "SELECT * FROM elettore WHERE codice_tessera_elettorale = ? AND password = SHA1(?) AND codice_carta_identita = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $codice_tessera, $password, $codice_documento);
        } else {
            //query con bind_param
            $sql = "SELECT * FROM elettore WHERE codice_tessera_elettorale = ? AND password = SHA1(?) AND codice_patente = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $codice_tessera, $password, $codice_documento);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            
            $_SESSION["id"] = $row["id_elettore"];
            $_SESSION["codice_tessera_elettorale"] = $row["codice_tessera_elettorale"];
            header("Location: ../pages/vota.php");
        } else {
            session_destroy();
            header("Location: ../?error=1");
        }

    }
?>