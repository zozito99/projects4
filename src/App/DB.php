<?php

namespace BlogApiSlim\App;
use PDO;
final class DB
{
    public ?PDO $connection= null;

    public function __construct()
    {
        if ($this->connection ==null){

            $host = $_ENV['DB_HOST'];
            $db = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];
            $dsn = "mysql:host=$host;dbname=$db";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];


            $this->connection=new PDO($dsn,$user,$pass,$options);
        }
    }


}