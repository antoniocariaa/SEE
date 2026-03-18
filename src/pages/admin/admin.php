<!DOCTYPE html>
<html lang="en">
<?php
    include "../../../includes/connection.php";
    if(!isset($_SESSION["id"]) || $_SESSION["tipo"] !== "a") {
        header("Location: ../../../public/index.php");
        exit;
    }
    
    // Query to select all "seggio"
    $query = "SELECT * FROM seggio";
    $result = mysqli_query($conn, $query);

    // Query to select all "partito"
    $partiti_query = "SELECT * FROM partito";
    $partiti_result = mysqli_query($conn, $partiti_query);

    $candidati_query = "SELECT * FROM candidato ";
    $candidati_result = mysqli_query($conn, $candidati_query);
?>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/2/2b/Emblem_of_Italy_%28black_and_white_without_striped_background%29.svg" sizes="any" type="image/svg+xml">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
    </script>
    <title>Scheda Elettorale Elettronica</title>
    <style>
        body {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"><pattern id="diagonalLines" patternUnits="userSpaceOnUse" width="10" height="10" patternTransform="rotate(45)"><line x1="0" y="0" x2="10" y2="0" stroke="%23fed7aa" stroke-width="0.5" /></pattern><rect width="100%" height="100%" fill="url(%23diagonalLines)" /></svg>');
            background-repeat: repeat;
        }
    </style>
</head>
<body class="bg-orange-100 h-full w-full">
    <div class="container mx-auto h-1/6">
        <div class="mx-auto mb-2 mt-10 w-24">
            <a href="logout.php">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2b/Emblem_of_Italy_%28black_and_white_without_striped_background%29.svg"
                    alt="Emblem of Italy (black and white without striped background).svg" class="w-full h-auto">
            </a>
        </div>
        <header class="text-center w-11/12 mx-auto">
            <h1 class="text-4xl font-bold font-serif">Repubblica Italiana</h1>
            <h2 class="text-2xl font-bold">Scheda Elettorale Elettronica</h2>
        </header>
    </div>
    <?php
        if(isset($_GET["error"])){
            echo "<div class='text-center text-red-500 font-bold'>Errore durante la modifica</div>";
        }
    ?>
    
    <div class="container mx-auto pt-10 h-6/6 w-6/6 justify-center">
        <div class="flex flex-row">
            <div class="w-1/3"> 
                <h3 class="text-2xl font-bold text-center">Gestione Seggi</h3>    
                <div class="flex flex-col mt-3">
                    <div class="flex flex-row p-4 justify-center border border-black">
                        <div class="w-1/3 p-4 justify-center">
                            <form action="aggiungi_seggio.php" method="post">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="mb-4">
                                    <input type="text" name="indirizzo" id="indirizzo" class="mb-1 block
                                    w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                    <label for="indirizzo" class="block italic text-sm font-medium text-gray-700">Indirizzo</label>
                                </div>
                                <div class="flex mx-auto justify-center pt-4 w-1/3">
                                    <button type="submit" class="w-full bg-orange-100 border-b-2 border-transparent hover:border-black text-black text-center font-bold py-2 px-4">✔️</button>
                                </div>
                            </form> 
                        </div>
                        <div class="w-2/3 p-4 h-full scrollable-div max-h-96 overflow-y-auto">
                            
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <div class="flex flex-row p-4 justify-between border border-black mt-4">
                                <form action="modifica_seggio.php" method="post" class="w-full flex items-center">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="id_seggio" value="<?php echo htmlspecialchars($row['id_seggio'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="text" name="indirizzo" id="indirizzo_<?php echo htmlspecialchars($row['id_seggio'], ENT_QUOTES, 'UTF-8'); ?>" class="mb-1 block
                                    w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" value="<?php echo htmlspecialchars($row['indirizzo'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <button type="submit" class="ml-4 bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">🖊️</button>
                                </form> 
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-2/3 pl-3">
                <h3 class="text-2xl font-bold text-center">Gestione Partiti</h3>
                <div class="flex flex-col mt-3">
                    <div class="flex flex-row p-4 justify-center border border-black">
                        <div class="w-2/6 p-4 justify-center">
                            <form action="aggiungi_partito.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="mb-4">
                                    <input type="text" name="sigla" id="sigla" class="mb-1 block
                                    w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                    <label for="sigla" class="block italic text-sm font-medium text-gray-700">Sigla</label>
                                </div>
                                <div class="mb-4">
                                    <input type="text" name="nome" id="nome" class="mb-1 block
                                    w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                    <label for="nome" class="block italic text-sm font-medium text-gray-700">Nome</label>
                                </div>
                                <div class="mb-4">
                                    <input type="file" name="simbolo" id="simbolo" class="mb-1 block
                                    w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                    <label for="simbolo" class="block italic text-sm font-medium text-gray-700">Simbolo</label>
                                </div>
                                <div class="flex mx-auto justify-center pt-4 w-1/3">
                                    <button type="submit" class="w-full bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">✔️</button>
                                </div>
                            </form>
                        </div>
                        <div class="w-4/6 p-4 h-full scrollable-div max-h-96 overflow-y-auto">
                            <?php while($row = mysqli_fetch_assoc($partiti_result)): ?>
                            <div class="flex flex-row p-4 justify-between border border-black mt-4">
                                <form action="modifica_partito.php" method="post" class="w-full flex items-center" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="vecchia_sigla" value="<?php echo htmlspecialchars($row['sigla'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="text" name="sigla" id="sigla_<?php echo htmlspecialchars($row['sigla'], ENT_QUOTES, 'UTF-8'); ?>" class="mb-1 block
                                    w-1/6 px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 mr-1 sm:text-sm" value="<?php echo htmlspecialchars($row['sigla'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <input type="text" name="nome" id="nome_<?php echo htmlspecialchars($row['sigla'], ENT_QUOTES, 'UTF-8'); ?>" class="mb-1 block
                                    w-3/6 px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" value="<?php echo htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <input type="file" name="simbolo" id="simbolo_<?php echo htmlspecialchars($row['sigla'], ENT_QUOTES, 'UTF-8'); ?>" class="mb-1 block
                                    w-1/6 px-3 py-2 bg-orange-100 rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" value="<?php echo htmlspecialchars($row['simbolo'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="ml-4 bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">🖊️</button>
                                </form>
                                <form action="elimina_partito.php" method="post">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="sigla" value="<?php echo htmlspecialchars($row['sigla'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="ml-4 bg-red-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">X</button>
                                </form>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="flex flex-row pt-4 pb-8">
            <div class="w-full">
                <?php
                
                
                $partiti2_result = mysqli_query($conn, $partiti_query);
                $testo = "<select name='partito' id='partito' class='mb-1 block w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm' required>";   
                $testo = $testo . "<option class='rounded-none hover:text-orange-200' value=''>Inserisci il partito</option>";          
                while($row = mysqli_fetch_assoc($partiti2_result)){
                    $testo = $testo . "<option class='rounded-none hover:text-orange-200' value='" . $row['sigla'] . "'>" . $row['nome'] . "</option>";
                }
                $testo = $testo . "</select>";
                
                ?>
                <h3 class="text-2xl font-bold text-center">Gestione Candidati</h3>
                <div class="flex flex-col mt-3">
                    <div class="flex flex-row p-4 justify-center border border-black">
                        <div class="w-2/6 p-4 justify-center max-height-96">
                            <form action="aggiungi_candidato.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="mb-4">
                                    <input type="text" name="nome" id="nome" class="mb-1 block
                                    w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                    <label for="sigla" class="block italic text-sm font-medium text-gray-700">Nome</label>
                                </div>
                                <div class="mb-4">
                                    <input type="text" name="cognome" id="cognome" class="mb-1 block
                                    w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                    <label for="nome" class="block italic text-sm font-medium text-gray-700">Cognome</label>
                                </div>
                                <div class="mb-4">
                                    <input type="date" name="data_nascita" id="data_nascita" class="mb-1 block
                                    w-full px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                    <label for="data_nascita" class="block italic text-sm font-medium text-gray-700">Data di nascita</label>
                                </div>
                                <div class="mb-4">
                                    <select name="sesso" id="sesso" class="mb-1 block w-full px-3 mr-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                        <option class="rounded-none hover:text-orange-200" value="">Inserisci il sesso</option>
                                        <option class="rounded-none hover:text-orange-200" value="F">Femmina</option>
                                        <option class="rounded-none hover:text-orange-200" value="M">Maschio</option>
                                    </select>
                                    <label for="sesso" class="block text-sm italic font-medium text-gray-700">Sesso</label>
                                </div>
                                <div class="mb-4">
                                    <?php echo htmlspecialchars($testo, ENT_QUOTES, 'UTF-8'); ?>
                                    <label for="partito" class="block text-sm italic font-medium text-gray-700">Partito</label>
                                </div>

                                <!-- SELECT option con partiti -->

                                <div class="flex mx-auto justify-center pt-4 w-1/3">
                                    <button type="submit" class="w-full bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">✔️</button>
                                </div>
                            </form>
                        </div>
                        <div class="w-4/6 p-4 h-full scrollable-div max-h-[30rem] overflow-y-auto">
                            <?php while($row = mysqli_fetch_assoc($candidati_result)): ?>


                            <!-- SELECT option con partiti  e mostra i candidati per partito-->


                            <div class="flex flex-row p-4 justify-between border border-black mt-4">
                                <form action="modifica_candidato.php" method="post" class="w-full flex items-center">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input hidden name="id_candidato" value="<?php echo htmlspecialchars($row['id_candidato'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="text" name="nome" id="<?php echo htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?>" class="mb-1 block
                                    w-1/6 px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 mr-1 sm:text-sm" value="<?php echo htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <input type="text" name="cognome" id="<?php echo htmlspecialchars($row['cognome'], ENT_QUOTES, 'UTF-8'); ?>" class="mb-1 block
                                    w-1/6 px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" value="<?php echo htmlspecialchars($row['cognome'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <input type="date" name="data_nascita" id="<?php echo htmlspecialchars($row['data_nascita'], ENT_QUOTES, 'UTF-8'); ?>" class="mb-1 block
                                    w-2/6 px-3 py-2 bg-orange-100 rounded-none focus:outline-none
                                    focus:ring-orange-300 focus:border-orange-300 sm:text-sm" value="<?php echo htmlspecialchars($row['data_nascita'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <select name="sesso" id="sesso" class="mb-1 block w-3/6 px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                        <option class="rounded-none hover:text-orange-200" value="">Inserisci il sesso</option>
                                        <?php
                                        if($row['sesso'] == "F"){
                                            echo "<option class='rounded-none hover:text-orange-200' value='F' selected>Femmina</option>";
                                            echo "<option class='rounded-none hover:text-orange-200' value='M'>Maschio</option>";
                                        }else{
                                            echo "<option class='rounded-none hover:text-orange-200' value='F'>Femmina</option>";
                                            echo "<option class='rounded-none hover:text-orange-200' value='M' selected>Maschio</option>";
                                        }
                                        ?>
                                    </select>
                                    <select name="partito" id="partito" class="mb-1 block w-3/6 px-3 py-2 bg-orange-100 border-b border-black rounded-none focus:outline-none focus:ring-orange-300 focus:border-orange-300 sm:text-sm" required>
                                        <option class="rounded-none hover:text-orange-200" value="">Inserisci il partito</option>
                                        <?php
                                        $partiti2_result = mysqli_query($conn, $partiti_query);
                                        while($row2 = mysqli_fetch_assoc($partiti2_result)){
                                            if($row2['sigla'] == $row['id_partito']){
                                                echo "<option class='rounded-none hover:text-orange-200' value='" . $row2['sigla'] . "' selected>" . $row2['nome'] . "</option>";
                                            }else{
                                                echo "<option class='rounded-none hover:text-orange-200' value='" . $row2['sigla'] . "'>" . $row2['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    
                                    <button type="submit" class="ml-4 bg-orange-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">🖊️</button>
                                </form>
                                <form action="elimina_candidato.php" method="post">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="id_candidato" value="<?php echo htmlspecialchars($row['id_candidato'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="ml-4 bg-red-100 border-b-2 border-transparent hover:border-black text-black font-bold py-2 px-4">X</button>
                                </form>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        </div>
                    </div>
                </div>   
                    
            </div>
        </div>
    </div>
</body>
</html>
