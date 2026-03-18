<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/2/2b/Emblem_of_Italy_%28black_and_white_without_striped_background%29.svg" sizes="any" type="image/svg+xml">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Scheda Elettorale Elettronica - Repubblica Italiana</title>
    <style>
        body {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"><pattern id="diagonalLines" patternUnits="userSpaceOnUse" width="10" height="10" patternTransform="rotate(45)"><line x1="0" y="0" x2="10" y2="0" stroke="%23fed7aa" stroke-width="0.5" /></pattern><rect width="100%" height="100%" fill="url(%23diagonalLines)" /></svg>');
            background-repeat: repeat;
        }
    </style>
</head>

<?php

    session_start();
    if(isset($_SESSION["id"])){
        header("Location: voting/vota.php");
    }

?>



<!-- bg-rose-100 -->
<body class="bg-orange-100 h-full">
    <div class="container mx-auto">
        <div class="mx-auto mb-2 mt-10 w-24">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2b/Emblem_of_Italy_%28black_and_white_without_striped_background%29.svg" alt="Emblem of Italy (black and white without striped background).svg" class="w-full h-auto">
        </div>
        <header class="text-center w-11/12 mx-auto">
            <h1 class="text-4xl font-bold font-serif">Repubblica Italiana</h1>
            <h2 class="text-2xl font-bold">Scheda Elettorale Elettronica</h2>
        </header>

        <?php
            if(isset($_GET["error"])){
                if($_GET["error"] == 1){
                    echo "<div class='text-center text-red-500 font-bold'>Credenziali errate</div>";
                } elseif($_GET["error"] == 2){
                    echo "<div class='text-center text-red-500 font-bold'>Utente già registrato</div>";
                }else{
                    echo "<div class='text-center text-red-500 font-bold'>Errore generico</div>";
                }
            }
        ?>
    </div>

    <!-- FORM login, campi necessari: codice tessera elettorale  Opzione select con tipo di documento (Carta identità / patente) e un campo per il codice del documento -->

    <div class="container mx-auto p-5 mt-20 w-5/6 md:w-4/6 lg:w-3/6 mb-5 border border-black ">
        <form action="pages/login.php" method="post">
            <div class="mb-4">
                <input type="text" name="codice_tessera" id="codice_tessera" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                <label for="codice_tessera" class="block italic text-sm font-medium text-gray-700">Tessera Elettorale</label>
            </div>
            <div class="mb-4">
                <select name="tipo_documento" id="tipo_documento" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                    <option class="rounded-none hover:text-orange-200" value="carta_identita">Carta Identità</option>
                    <option class="rounded-none" value="patente">Patente</option>
                </select>
                <label for="tipo_documento" class="block text-sm italic font-medium text-gray-700">Tipo Documento</label>
            </div>
            <div class="mb-4">
                <input type="text" name="codice_documento" id="codice_documento" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                <label for="codice_documento" class="block text-sm font-medium italic text-gray-700">Documento</label>
            </div>
            <div class="mb-4">
                <input type="password" name="password" id="password" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                <label for="password" class="block italic text-sm font-medium text-gray-700">Password</label>
            </div>
            <div class="flex mx-auto justify-center">
                <div class="mb-4 w-auto pl-10 pr-10">
                    <button type="submit" class="w-full bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">Accedi</button>
                </div>
                <div class="mb-4 w-auto pl-10 pr-10">
                    <button onclick="location.href='pages/register.php'" class="w-full bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">Registrati</button>
                </div>
            </div>
            
        </form>
    </div>

    <a href="pages/admin/spoglio.php" class="block w-6/12 md:w-4/12 lg:w-2/12  mx-auto bg-orange-100 text-center border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4 mt-5">Visualizza Spoglio Schede</a>




</body>
</html>
