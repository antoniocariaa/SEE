<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/2/2b/Emblem_of_Italy_%28black_and_white_without_striped_background%29.svg" sizes="any" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheda Elettorale Elettronica</title>
</head>
<body class="bg-orange-100 h-full">
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
        include "connection.php";
        $sql = "select count(*) as voti, sigla from see, partito where conteggiato = 1 and see.id_partito = partito.sigla group by id_partito";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $labelsRisultati = array();
        $dataRisultati = array();
        while($row = $result->fetch_assoc()){
            array_push($labelsRisultati, $row["sigla"]);
            array_push($dataRisultati, $row["voti"]);
        }



        $sql = "select count(*) as voti, hour(data_voto) as ora from see where conteggiato = 1 group by hour(data_voto)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $labelsOrario = array();
        $dataOrario = array();
        while($row = $result->fetch_assoc()){
            array_push($labelsOrario, $row["ora"]);
            array_push($dataOrario, $row["voti"]);
        }

    ?>

    <div class="container mx-auto p-5 mt-20 w-6/6 md:w-5/6 lg:w-4/6 mb-5 text-center border border-black">
        <h1 class="text-2xl font-bold">Risultati</h1>
        <div class="w-11/12 flex flex-col mx-auto">
            <canvas id="Risultati" ></canvas>
            
        </div>
    </div>
    <div class="container mx-auto p-5 mt-10 w-6/6 md:w-5/6 lg:w-4/6 mb-5 text-center border border-black">
        <h1 class="text-2xl font-bold">Affluenza ai seggi</h1>
        <div class="w-11/12 flex flex-col mx-auto">
            <canvas id="OrarioAffluenza" ></canvas>  
        </div>
    </div>
    <div class="container mx-auto p-5 mt-10 w-6/6 md:w-5/6 lg:w-4/6 mb-5 text-center border border-black">
        <h1 class="text-2xl font-bold">Voti per Candidato</h1>
        <div class="w-11/12 flex flex-col mx-auto">
            <canvas id="Voti per candidato" ></canvas>  
        </div>
    </div>
    <div class="container mx-auto p-5 mt-10 w-6/6 md:w-5/6 lg:w-4/6 mb-5 text-center border border-black">
        <h1 class="text-2xl font-bold">Statistiche per votanti</h1>
        <div class="w-11/12 flex flex-col mx-auto">
            <canvas id="Voti per candidato" ></canvas>  
        </div>
        <!-- TODO 
            EDIT SEGGIO FOR MAP VOTI
            ADD new statistiche
            ADD grafica sfondo (antifrode?)

            set SEE anonima con fk NULL
            EDIT elettore con FLAG VOTO
            SPOGLIO AL TERMINE
        -->

    </div>
</body>
<script>
    $(document).ready(function(){
        var ctx = document.getElementById('Risultati').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labelsRisultati); ?>,
                datasets: [{
                    label: 'Voti',
                    data: <?php echo json_encode($dataRisultati); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 22, 164, 0.2)',
                        'rgba(44, 19, 75, 0.2)',
                        'rgba(122, 86, 64, 0.2)' 
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 22, 164, 1)',
                        'rgba(44, 19, 75, 1)',
                        'rgba(122, 86, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Voti per partito'
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index];
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            var percent = Math.round((value / data.datasets[tooltipItem.datasetIndex].data.reduce((a, b) => a + b, 0)) * 100);
                            return label + ': '+value + ' - ' + percent + '%';
                        }
                    }
                }
            }
        });

        var ctx = document.getElementById('OrarioAffluenza').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labelsOrario); ?>,
                datasets: [{
                    label: 'Orario',
                    data: <?php echo json_encode($dataOrario); ?>,
                    backgroundColor: 'rgba(249, 115, 22, 0.2)', 
                    borderColor: 'rgba(249, 115, 22, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Affluenza per ora'
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index];
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return label + ': '+value;
                        }
                    }
                }
            }
        });
    });

</script>
</html>
