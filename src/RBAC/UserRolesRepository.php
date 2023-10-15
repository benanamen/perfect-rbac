<?php

declare(strict_types=1);

namespace PerfectApp\RBAC;

use PDO;

/**
 *
 */
class UserRolesRepository
{
    /**
     * @param PDO $pdo
     */
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @param int $userId
     * @return array|false
     */
    public function getUserRoles(int $userId): array|false
    {
        $stmt = $this->pdo->prepare('SELECT r.role_name FROM user_roles ur
                                    JOIN roles r ON ur.role_id = r.role_id
                                    WHERE ur.user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}
