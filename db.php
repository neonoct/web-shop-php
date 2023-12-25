<?php
//make a function connectToDb that returns a connection to the database

function connectToDb(){
    $host     = "localhost";
    $dbName   = "shopDb";
    $username = "Webuser";
    $password = "Lab2021";
    $conn = new mysqli($host, $username, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}


?>