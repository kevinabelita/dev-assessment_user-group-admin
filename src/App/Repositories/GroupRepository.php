<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database;

class GroupRepository
{
    public function __construct(private Database $db)
    {
    }

    public function getAll()
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->query('SELECT * FROM `groups`');
        
        return $stmt->fetchAll();
    }
}