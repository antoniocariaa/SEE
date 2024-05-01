<!DOCTYPE html>
<html lang="en">

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
        if($_POST["pin"] == $row["pin"]){
            if($row["conteggiato"] == 1){
                $_SESSION["pin"] = -1;
                header("Location: vota.php");
            }
        }else{
            header("Location: vota.php?error=1");
        }
        
    }else{
        $sql = "insert into see (id_elettore, pin) values (?, ?)";
        $stmt = $conn->prepare($sql);
        $pin = rand(10000, 99999);
        $stmt->bind_param("ii", $_SESSION["id"], $pin);
        $stmt->execute();
        header("Location: vota.php");
    }
?>


<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheda Elettorale Elettronica</title>
</head>
<body class="bg-orange-100 h-full">
    <div class="container mx-auto">
        <div class="mx-auto mb-2 mt-10 w-24">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2b/Emblem_of_Italy_%28black_and_white_without_striped_background%29.svg" alt="Emblem of Italy (black and white without striped background).svg" class="w-full h-auto">
        </div>
        <header class="text-center w-11/12 mx-auto">
            <h1 class="text-4xl font-bold font-serif">Repubblica Italiana</h1>
            <h2 class="text-2xl font-bold">Scheda Elettorale Elettronica</h2>
        </header>
    </div>
    <div class="container h-full mx-auto p-5 mt-20 w-9/12 flex flex-col md:flex-row md:w-10/12 lg:w-11/12 mb-5 text-center border border-black">
        <div class="h-full mx-auto p-5 mt-5 mx-2 px-2 w-5/6 md:w-4/6 lg:w-3/6 mb-5 text-center border md:border-r border-black">

        <!-- TODO: FIX bordo laterale e aggiunta query partiti e candidati + form preferenze -->


        </div>
        <div class="h-full mx-auto p-5 mt-5 mx-2 px-2 w-5/6 md:w-4/6 lg:w-3/6 mb-5 text-center border md:border-l border-black">
        </div>

    </div>

    
</body>
</html>