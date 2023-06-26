<?php

declare(strict_types=1);

namespace PerfectApp\RBAC;

use PDO;

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
     * @return mixed
     */
    public function getUserRole(int $userId): mixed
    {
        $stmt = $this->pdo->prepare('SELECT r.role_name FROM user_roles ur
                                    JOIN roles r ON ur.role_id = r.role_id
                                    WHERE ur.user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
