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
            // $sql = "update see set conteggiato = 1, data_voto = curtime()".
            //         (!empty($_POST["partito"])) ? ', id_partito = ?' : ''.
            //         (!empty($_POST["candidato1"])) ? ', preferenza_1 = ?' : ''.
            //         (!empty($_POST["candidato2"])) ? ', preferenza_2 = ?' : ''.
            //         " where pin ='". $_SESSION["pin"]."';";
            // $stmt = $conn->prepare($sql);
            // . (!empty($_POST["partito"])) ? ', id_partito = ?' : ''
            // . (!empty($_POST["candidato1"])) ? ', preferenza_1 = ?' : ''
            // . (!empty($_POST["candidato2"])) ? ', preferenza_2 = ?' : ''

            // $stmt->bind_param("sii", $_POST["partito"], $_POST["candidato1"], $_POST["candidato2"]);

            $conn->query("START TRANSACTION");



            $sql = "update see set conteggiato = 1, data_voto = curtime() where pin =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $_SESSION["pin"]);
            $stmt->execute();

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
            $params[] = $_SESSION["pin"];
            $stmt->execute();
            $conn->prepare("commit")->execute();
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