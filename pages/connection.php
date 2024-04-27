<?php

    session_start();

    $conn = new mysqli("localhost", "root", "", "votazioni");

    if ($conn->connect_error) {
        die(["error" => "Connessione Fallita: " . $conn->connect_error]);
    }
?>