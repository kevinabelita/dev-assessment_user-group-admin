<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database;
use PDO;

class UserGroupRepository
{
    public function __construct(private Database $db)
    {
    }

    public function getByUserId(int $id): array|bool
    {
        $pdo = $this->db->getConnection();
        $sql = '
        SELECT 
            g.groupid, 
            g.groupname 
        FROM groups AS g 
        JOIN user_groups AS ug
        ON ug.groupid = g.groupid
        WHERE ug.userid = :userid
        ';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userid', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function updateByUserId(int $id, array $data): int
    {
        $affectedRows = 0;
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare('DELETE FROM user_groups WHERE userid = :userid');
        $stmt->bindValue(':userid', $id, PDO::PARAM_INT);
        $stmt->execute();

        $createdUpdatedBy = 1;
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $sql = '
        INSERT INTO user_groups (userid, groupid, created_by, created_date, updated_by, updated_date)
        VALUES (:userid, :groupid, :created_by, :created_date, :updated_by, :updated_date)
        ';
        $stmt = $pdo->prepare($sql);
        foreach ($data as $groupId) {
            $stmt->bindValue(':userid', $id, PDO::PARAM_INT);
            $stmt->bindValue(':groupid', (int) $groupId, PDO::PARAM_INT);
            $stmt->bindValue(':created_by', $createdUpdatedBy, PDO::PARAM_INT);
            $stmt->bindValue(':created_date', $now, PDO::PARAM_STR);
            $stmt->bindValue(':updated_by', $createdUpdatedBy, PDO::PARAM_INT);
            $stmt->bindValue(':updated_date', $now, PDO::PARAM_STR);
            $stmt->execute();

            $affectedRows += intval($pdo->lastInsertId() > 0);
        }

        return $affectedRows;
    }
}