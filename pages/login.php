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
        $sql = "insert into elettore (codice_tessera_elettorale, codice_carta_identita, codice_patente, password, salt, id_seggio) values (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // gereazione del salt per la password
        $salt = strval(md5(uniqid(rand(), true)));
        $salt = substr($salt, 0, 10);
        $bind_codice_tessera = $codice_tessera;
        $bind_codice_identita = $codice_identita;
        $bind_codice_patente = $codice_patente;
        $bind_password = crypt($password, $salt);
        $bind_salt = $salt;
        $bind_seggio = $seggio;

        $stmt->bind_param("sssssi", $bind_codice_tessera, $bind_codice_identita, $bind_codice_patente, $bind_password, $bind_salt, $bind_seggio);

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
            $sql = "SELECT * FROM elettore WHERE codice_tessera_elettorale = ? AND codice_carta_identita = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $codice_tessera, $codice_documento);
        } else {
            //query con bind_param
            $sql = "SELECT * FROM elettore WHERE codice_tessera_elettorale = ? AND codice_patente = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $codice_tessera, $codice_documento);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            echo $row["password"] . " = " . crypt($password, $row["salt"]) . "<br>";

            if($row["password"] == crypt($password, $row["salt"])){
                $_SESSION["id"] = $row["id_elettore"];
                $_SESSION["codice_tessera_elettorale"] = $row["codice_tessera_elettorale"];
                header("Location: ../pages/vota.php");
            } else {
                session_destroy();
                header("Location: ../?error=".$row["password"] . " = " . crypt($password, $row["salt"]));
            }
        } else {
            session_destroy();
            header("Location: ../?error=1");
        }

    }
?>