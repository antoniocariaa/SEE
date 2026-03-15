<!DOCTYPE html>
<html lang="en">

<?php

include "../../../includes/connection.php";

if (!isset($_SESSION["id"])) {
    header("Location: ../../../public/index.php");
}

$sql = "select id_see, conteggiato, pin from see where id_elettore = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION["codice_tessera_elettorale"]);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($_POST["pin"] == $row["pin"]) {
        if ($row["conteggiato"] == 1) {
            $_SESSION["pin"] = -1;
            header("Location: vota.php");
        }
    } else {
        header("Location: vota.php?error=1");
    }

} else {
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
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/2/2b/Emblem_of_Italy_%28black_and_white_without_striped_background%29.svg" sizes="any" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
        </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheda Elettorale Elettronica</title>
    <style>
        body {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"><pattern id="diagonalLines" patternUnits="userSpaceOnUse" width="10" height="10" patternTransform="rotate(45)"><line x1="0" y="0" x2="10" y2="0" stroke="%23fed7aa" stroke-width="0.5" /></pattern><rect width="100%" height="100%" fill="url(%23diagonalLines)" /></svg>');
            background-repeat: repeat;
        }
    </style>
</head>

<body class="bg-orange-100 h-full">
    <div class="container mx-auto h-1/6">
        <div class="mx-auto mb-2 mt-10 w-24">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2b/Emblem_of_Italy_%28black_and_white_without_striped_background%29.svg"
                alt="Emblem of Italy (black and white without striped background).svg" class="w-full h-auto">
        </div>
        <header class="text-center w-11/12 mx-auto">
            <h1 class="text-4xl font-bold font-serif">Repubblica Italiana</h1>
            <h2 class="text-2xl font-bold">Scheda Elettorale Elettronica</h2>
        </header>
    </div>
    <div
        class="container max-h-4/6 mx-auto p-5 mt-20 w-9/12 flex flex-col sm:flex-row md:w-10/12 lg:w-11/12 mb-5 text-center border md:border-l border-black">

        <div
            class="mx-auto max-h-[550px] p-5 mt-5 mx-2 px-2 w-5/6 md:w-5/6 lg:w-3/6 mb-5 overflow-y-auto text-center sm:border-r sm:border-y-transparent sm:border-l-transparent border border-black">
            <?php

            $sql = "select sigla, simbolo, nome from partito ORDER BY RAND()";
            $result = $conn->query($sql);

            $first = true;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($first) {
                        echo '<div class="flex flex-col sm:flex-row mb-3 mx-2">';
                        $first = false;
                    } else {
                        echo '<div class="flex flex-col sm:flex-row border-black border-t my-3 mx-2">';
                    }
                    echo '<div class="flex-1 mt-3 place-items-center">';
                    echo '<img class="place-self-center" src="' . $row["simbolo"] . '" alt="' . $row["sigla"] . '">';
                    echo '</div>';
                    echo '<div class="flex-1 flex flex-col justify-center">';
                    echo '<h3 class="text-2xl font-bold">' . $row["sigla"] . '</h3>';
                    echo '<h4 class="text-xl font-bold">' . $row["nome"] . '</h4>';
                    echo '<button class="w-full pulsante-voto bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-4 px-4" id=\'' . $row["sigla"] . '\'>Seleziona</button>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<h3 class="text-2xl font-bold">Nessun partito disponibile</h3>';
            }

            ?>
        </div>
        <div class="h-full mx-auto p-5 mt-5 mx-2 px-2 w-5/6 md:w-5/6 lg:w-3/6 mb-5 text-center">

    <h3 class="text-2xl font-bold" id="titolo-candidati">Seleziona prima un partito</h3>

    <div class="hidden flex flex-col mb-3 mx-2 h-full content-center" id="container-candidati">
        <div class="flex-1 mt-3 place-items-center  pt-10" id="candidato-1-cont">
            <select
                class="place-self-center w-3/4 bg-orange-100 border-b-2 border-black text-black font-bold py-4 px-4"
                id="candidato-1" disabled>
                <option value="">Seleziona un candidato</option>
            </select>
        </div>
        <div class="flex-1 mt-3 place-items-center pt-10" id="candidato-2-cont">
            <select
                class="place-self-center w-3/4 bg-orange-100 border-b-2 border-black text-black font-bold py-4 px-4"
                id="candidato-2" disabled>
                <option value="">Seleziona un candidato</option>
            </select>
        </div>
    </div>

    <div class="flex mx-auto justify-center mt-auto pt-10">
        <button class="w-4/6 bg-orange-200 border-b-2 border-transparent hover:border-black object-bottom text-black font-bold py-4 px-4"
            id="conferma-vota">Vota</button>
    </div>

    </div>
    </div>

    <div id="confirm-vote-modal" class="fixed inset-0 bg-orange-100 flex flex-col items-center justify-center p-8 rounded-lg shadow-lg hidden">
        <div class="text-center mt-30">
            <h2 class="text-4xl font-bold font-serif mb-4">Conferma la tua votazione</h2>
            <p class="text-2xl font-bold mb-8">Sei sicuro di voler confermare la tua votazione?</p>
            <button class="bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-4 px-4" id="confirm-vote-button">Conferma</button>
            <button class="bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-4 px-4" id="cancel-vote-button">Annulla</button>
        </div>
    </div>

</body>
    <script>

        var partito = "";

        $(".pulsante-voto").click(function () {
            $("#candidato-1").prop("disabled", true);
            $("#candidato-2").prop("disabled", true);
            var sigla = $(this).attr("id");
            partito = sigla;
            $.ajax({
                url: "selectCandidati.php",
                type: "POST",
                // contentType: "application/json",
                data: { sigla: sigla },
                success: function (data) {
                    var candidati = JSON.parse(data);
                    $("#titolo-candidati").text("Seleziona i candidati del partito "+ sigla);
                    $("#candidato-1").empty();
                    $("#candidato-1").append("<option value=''>Seleziona un candidato</option>");
                    $("#candidato-2").empty();
                    $("#candidato-2").append("<option value=''>Seleziona un candidato</option>");
                    for (var i = 0; i < candidati.length; i++) {
                        $("#candidato-1").append("<option value='" + candidati[i].id_candidato + "'>" + candidati[i].nome + " " + candidati[i].cognome + "</option>");
                    }
                    $("#container-candidati").removeClass("hidden");
                    $("#candidato-1").prop("disabled", false);
                }
            });
        });

        $("#candidato-1").on('change', function () {
            
            $.ajax({
                url: "selectCandidati.php",
                type: "POST",
                data: { 
                    candidato1: $(this).val(),
                    sigla: partito
                },
                success: function (data) {
                    var candidato = JSON.parse(data);
                    
                    $("#candidato-2").empty();
                    $("#candidato-2").append("<option value=''>Seleziona un candidato</option>");
                    for (var i = 0; i < candidato.length; i++) {
                        $("#candidato-2").append("<option value='" + candidato[i].id_candidato + "'>" + candidato[i].nome + " " + candidato[i].cognome + "</option>");
                    }
                    $("#candidato-2").prop("disabled", false);
                    
                    
                }
            });
        });

        $("#confirm-vote-button").click(function () {
            var candidato1 = $("#candidato-1").val();
            var candidato2 = $("#candidato-2").val();
        
            $.ajax({
                url: "ConfermaVoto.php",
                type: "POST",
                data: {
                    partito: partito,
                    candidato1: candidato1,
                    candidato2: candidato2
                },
                success: function (data) {
                    console.log(data);
                    if (data == "ok") {
                        location.href = "vota.php";
                    } else {
                        alert("Errore durante il voto");
                    }
                }
            });

            $("#confirm-vote-modal").addClass("hidden");
        });

        $("#cancel-vote-button").click(function () {
            $("#confirm-vote-modal").addClass("hidden");
        });

        $("#conferma-vota").click(function () {
            $("#confirm-vote-modal").removeClass("hidden");
            
        });

    </script>
</html>