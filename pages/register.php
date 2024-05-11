<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Scheda Elettorale Elettronica - Repubblica Italiana</title>
</head>

<?php

    session_start();
    if(isset($_SESSION["id"])){
        header("Location: vota.php");
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
    </div>

    <!-- FORM login, campi necessari: codice tessera elettorale  Opzione select con tipo di documento (Carta identità / patente) e un campo per il codice del documento -->

    <div class="container mx-auto p-5 mt-20 w-5/6 md:w-4/6 lg:w-3/6 mb-5 border border-black ">
        <form action="login.php" method="post">
            <div class="mb-4">
                <input type="text" name="codice_tessera" id="codice_tessera" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                <label for="codice_tessera" class="block italic text-sm font-medium text-gray-700">Tessera Elettorale</label>
            </div>
            <div class="mb-4">
                <input type="password" name="password" id="password" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                <label for="password" class="block italic text-sm font-medium text-gray-700">Password</label>
            </div>
            <div class="mb-4">
                <input type="text" name="codice_patente" id="codice_patente" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm">
                <label for="codice_patente" class="block text-sm font-medium italic text-gray-700">Patente</label>
            </div>
            <div class="mb-4">
                <input type="text" name="codice_identita" id="codice_identita" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                <label for="codice_identita" class="block text-sm font-medium italic text-gray-700">Carta Identità</label>
            </div>
            <div class="mb-4">
                <select name="seggio" id="seggio" class="mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                    <option class="rounded-none hover:text-orange-200" value="">Seleziona il tuo seggio</option>
                    <?php
                        include "connection.php";
                        $sql = "SELECT * FROM seggio";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option class='rounded-none' value='".$row["id_seggio"]."'>".$row["indirizzo"]."</option>";
                            }
                        } else {
                            echo "<option class='rounded-none' value=''>Nessun Seggio presente</option>";
                        }
                    ?>
                </select>
                <label for="seggio" class="block text-sm italic font-medium text-gray-700">Seggio</label>
            </div>
            <div class="flex mx-auto justify-center">
                <div class="mb-4 w-auto pl-10 pr-10">
                    <button type="submit" class="w-full bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">Registrati</button>
                </div>
                <div class="mb-4 w-auto pl-10 pr-10">
                    <button onclick="location.href='../'" class="w-full bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">Accedi</button>
                </div>
            </div>
            
        </form>
    </div>




</body>
</html>
