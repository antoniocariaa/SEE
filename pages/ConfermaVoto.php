<?php

    include "connection.php";

    if(!isset($_SESSION["id"])){
        header("Location: ../");
    }

    $sql = "select id_see, conteggiato, pin from see where id_elettore = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION["id"]);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION["pin"] = $row["pin"];

        if($row["conteggiato"] == 1){
            $_SESSION["pin"] = -1;
            header("Location: vota.php");
        }else{
            $sql = "update see set conteggiato = 1, data_voto = curtime(), id_partito = ?, preferenza_1 = ?, preferenza_2 = ? where pin ='". $_SESSION["pin"]."';";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $_POST["partito"], $_POST["candidato1"], $_POST["candidato2"]);
            $stmt->execute();
            $_SESSION["pin"] = -1;
            echo "ok";
        }
    }else{
        $sql = "insert into see (id_elettore, pin) values (?, ?)";
        $stmt = $conn->prepare($sql);
        $pin = rand(10000, 99999);
        $stmt->bind_param("ii", $_SESSION["id"], $pin);
        $stmt->execute();
        $_SESSION["pin"] = $pin;
        header("Location: scheda.php");
    }



?>