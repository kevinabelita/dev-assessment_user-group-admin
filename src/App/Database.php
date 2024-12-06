<?php
declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function __construct(
        private string $host,
        private string $name,
        private string $user,
        private string $password
    ) {

    }

    public function getConnection(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8;port=3306";
        $pdo = new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return $pdo;
    }
}