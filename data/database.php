<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $db_name = "scheduling_project";

    $conn = new PDO("mysql:host=$host;dbname=$db_name;", $username, $password);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

?>