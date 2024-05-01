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
        }
    }else{
        $sql = "insert into see (id_elettore, pin) values (?, ?)";
        $stmt = $conn->prepare($sql);
        $pin = rand(10000, 99999);
        $stmt->bind_param("ii", $_SESSION["id"], $pin);
        $stmt->execute();
        $_SESSION["pin"] = $pin;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
    <title>Scheda Elettorale Elettronica - Repubblica Italiana</title>
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

    <div class="container mx-auto p-5 mt-20 w-5/6 md:w-4/6 lg:w-3/6 mb-5 text-center border border-black">
    <?php
        if($_SESSION["pin"] == -1){
            echo "<p class=\"font-bold text-4xl\">Hai già compilato la scheda elettorale per questa votazione</p>";
        } else {
            echo "<p class=\" text-4xl\">Il tuo pin è: <span class=\"font-bold\" id=\"pinspan\">*******</span></p>";
            echo "<p class=\"text-md pt-3 font-serif\">Trascina il cursore per mostrare</p>";
            // crea un form per inserire il pin
            echo "<form action=\"scheda.php\" method=\"post\" class=\"pt-4\">";
            if(isset($_GET["error"])){
                echo "<p class=\"text-red-500\">Pin errato</p>";
            }
            echo "<input type=\"password\" name=\"pin\" id=\"pin\" class=\"mb-1 block w-1/2 mx-auto px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm\" required>";
            echo "<div class=\"flex mx-auto justify-center pt-4 w-1/3\">";
            echo "<button type=\"submit\" class=\"w-full bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4\">Apri scheda</button>";
            echo "</div>";
            echo "</form>";
        }
    ?>
    </div>

    <script>

        var pin = <?php echo $_SESSION["pin"]; ?>;
        $(document).ready(function(){

            //quando il mouse va in hover sul pin lo mostra altrimenti lo nasconde
            $("#pinspan").hover(function(){
                $(this).text(pin);
            }, function(){
                $(this).text("*******");
            });
        });            
    </script>
</body>
</html>