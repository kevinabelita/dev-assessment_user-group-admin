<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database;
use PDO;

class UserRepository
{
    public function __construct(private Database $db)
    {
    }

    public function getAll()
    {
        $pdo = $this->db->getConnection();
        $sql = "
        SELECT u.*, GROUP_CONCAT(g.groupname SEPARATOR ', ') AS usergroups FROM users AS u
        LEFT JOIN user_groups AS ug ON u.userid = ug.userid
        LEFT JOIN `groups` AS g ON ug.groupid = g.groupid
        GROUP BY u.userid
        ORDER BY u.userid
        ";
        $stmt = $pdo->query($sql);
        
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|bool
    {
        $pdo = $this->db->getConnection();
        $sql = 'SELECT * FROM users WHERE userid = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function create(array $data): int
    {
        $pdo = $this->db->getConnection();
        $createdUpdatedBy = 1;
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $sql = '
            INSERT INTO users (email, name, phone, created_by, created_date, updated_by, updated_date)
            VALUES (:email, :name, :phone, :created_by, :created_date, :updated_by, :updated_date)
        ';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindValue(':created_by', $createdUpdatedBy, PDO::PARAM_INT);
        $stmt->bindValue(':created_date', $now, PDO::PARAM_STR);
        $stmt->bindValue(':updated_by', $createdUpdatedBy, PDO::PARAM_INT);
        $stmt->bindValue(':updated_date', $now, PDO::PARAM_STR);
        $stmt->execute();

        return (int) $pdo->lastInsertId();
    }

    public function update(int $id, array $data): int
    {
        $pdo = $this->db->getConnection();
        $createdUpdatedBy = 1;
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $sql = 'UPDATE users SET email = :email, name = :name, phone = :phone, updated_by = :updated_by, updated_date = :updated_date WHERE userid = :userid';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindValue(':updated_by', $createdUpdatedBy, PDO::PARAM_INT);
        $stmt->bindValue(':updated_date', $now, PDO::PARAM_STR);
        $stmt->bindValue(':userid', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(int $id): int
    {
        $pdo = $this->db->getConnection();
        $sql = 'DELETE FROM users WHERE userid = :userid';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userid', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}