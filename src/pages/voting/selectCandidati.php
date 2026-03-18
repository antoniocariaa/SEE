<?php


//controlla se la richiesta è stata fatto con xmlhttprequest

if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest"){
    include "../../../includes/connection.php";
    if(!isset($_POST["candidato1"]) && isset($_POST["sigla"])){
        $sigla = $_POST["sigla"];
        $sql = "select * from candidato where id_partito = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sigla);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $candidati = array();
            while($row = $result->fetch_assoc()){
                $candidati[] = $row;
            }
            echo json_encode($candidati);
        }else{
            echo json_encode(array("error" => "Nessun candidato disponibile"));
        }
    }elseif(isset($_POST["candidato1"]) && isset($_POST["sigla"])){
        $id = $_POST["candidato1"];
        $sigla = $_POST["sigla"];
        $sql = "select * from candidato where id_candidato != ? and sesso != (select sesso from candidato where id_candidato = ?) AND id_partito = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $id, $id, $sigla);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $candidati = array();
            while($row = $result->fetch_assoc()){
                $candidati[] = $row;
            }
            echo json_encode($candidati);
        }else{
            echo json_encode(array("error" => "Nessun candidato disponibile"));
        }

    }else{
        echo json_encode(array("error" => "Richiesta non valida"));
    }
}else{
    header("Location: ../../../public/index.php");
}

?>