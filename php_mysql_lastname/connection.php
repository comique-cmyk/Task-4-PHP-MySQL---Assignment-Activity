<?php
function Connect(): PDO
{
    $host = "localhost";
    $db = "db_employee";
    $user = "root";
    $pass = "";
    $charset = "utf8mb4";

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try{
        return new PDO($dsn, $user, $pass, $option);
    } catch(PDOException $e){
        die("Database connection failed. Please contact the administrator.");
        echo $e->getMessage();
    }
}
?>