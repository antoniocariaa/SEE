<?php

    include "../../../includes/connection.php";

    if(!isset($_SESSION["id"])){
        header("Location: ../../../public/index.php");
    }

    $sql = "select id_see, conteggiato, pin from see where id_elettore = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["codice_tessera_elettorale"]);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION["pin"] = $row["pin"];

        if($row["conteggiato"] == 1){
            $_SESSION["pin"] = -1;
            header("Location: vota.php");
        }else{

            $conn->query("START TRANSACTION");

            $sql = "update see join elettore on see.id_elettore = elettore.codice_tessera_elettorale set conteggiato = 1, votato = 1, see.id_elettore = ?, data_voto = curtime() where pin =?";
            $stmt = $conn->prepare($sql);
            $conn->query("SET FOREIGN_KEY_CHECKS=0;");
            $empty_str = '';
            $stmt->bind_param('ss', $empty_str, $_SESSION["pin"]);
            $stmt->execute();
            $conn->query("SET FOREIGN_KEY_CHECKS=1;");

            if (isset($_POST["partito"]) && !empty($_POST["partito"])) {
                $stmt = $conn->prepare("update see set id_partito = ? where pin =? ");
                $stmt->bind_param('ss',$_POST["partito"], $_SESSION["pin"]);
                $stmt->execute();
            }
            if (isset($_POST["candidato1"]) && !empty($_POST["candidato1"])) {
                $stmt = $conn->prepare("update see set preferenza_1 = ? where pin =? ");
                $stmt->bind_param('ss',$_POST["candidato1"], $_SESSION["pin"]);
                $stmt->execute();
            }
            if (isset($_POST["candidato2"]) && !empty($_POST["candidato2"])) {
                $stmt = $conn->prepare("update see set preferenza_2 = ? where pin =? ");
                $stmt->bind_param('ss',$_POST["candidato2"], $_SESSION["pin"]);
                $stmt->execute();
            }
            $conn->query("commit");
            $_SESSION["pin"] = -1;
            echo "ok";
        }
    }else{
        $sql = "insert into see (id_elettore, pin) values (?, ?)";
        $stmt = $conn->prepare($sql);
        $pin = random_int(100000, 999999);
        $stmt->bind_param("ss", $_SESSION["codice_tessera_elettorale"], $pin);
        $stmt->execute();
        $_SESSION["pin"] = $pin;
        header("Location: scheda.php");
    }



?>