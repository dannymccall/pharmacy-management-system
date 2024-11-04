<?php

    $host = 'localhost';
    $dbname = 'pharmacy';
    $username = 'root';
    $password = '';

    try{
        
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
        $pdo = new PDO($dsn, $username,$password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    }catch(PDOException $e){
        echo "connection failed ". $e->getMessage();
    }
