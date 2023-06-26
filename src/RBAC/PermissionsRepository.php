<?php

declare(strict_types=1);

namespace PerfectApp\RBAC;

use PDO;

class PermissionsRepository
{
    /**
     * @param PDO $pdo
     */
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @param int $userId
     * @param string $requiredPermission
     * @return bool
     */
    public function userRoleHasPermission(int $userId, string $requiredPermission): bool
    {
        $sql = "SELECT COUNT(*) AS count
                FROM user_roles ur
                INNER JOIN role_permissions rp ON ur.role_id = rp.role_id
                INNER JOIN permissions p ON rp.permission_id = p.permission_id
                WHERE ur.user_id = :userId AND p.permission_name = :requiredPermission";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'userId' => $userId,
            'requiredPermission' => $requiredPermission
        ]);

        /** @var array<string, mixed>|false $result */
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false && $result['count'] > 0;
    }
}
