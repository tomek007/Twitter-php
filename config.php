<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "coderslab";
$DB_DBNAME = "twitter";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);

    if ($conn->connect_error) {
        die("Conection Error. Error: <br>" . $conn->connect_error);
    }


