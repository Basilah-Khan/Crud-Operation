<?php

date_default_timezone_set('Asia/Kolkata');

$local = 1;
if($local == 1)
{
     $host = 'localhost';
     $db   = 'crud';
     $user = 'root';
     $pass = 'root';
}else{
     $host = '';
     $db   = '';
     $user = '';
     $pass = '';  
}


$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new \PDO($dsn, $user, $pass, $options);
     //echo "Connection Done!! <br>";
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
     //echo "Connection Error!! <br>";
}

?>