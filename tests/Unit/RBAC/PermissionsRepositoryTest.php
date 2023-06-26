<?php declare(strict_types=1);

namespace Unit\RBAC;

use PDO;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PerfectApp\RBAC\PermissionsRepository;

#[CoversClass(PermissionsRepository::class)]
class PermissionsRepositoryTest extends TestCase
{
    private PDO $pdo;
    private PermissionsRepository $permissionsRepository;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        // Set up the database schema and data for testing

        $this->permissionsRepository = new PermissionsRepository($this->pdo);
    }

    public function testUserRoleHasPermission(): void
    {
        // Test case 1: User has the required permission
        $this->pdo->exec("
            CREATE TABLE user_roles (
                user_id INT,
                role_id INT
            );
            CREATE TABLE role_permissions (
                role_id INT,
                permission_id INT
            );
            CREATE TABLE permissions (
                permission_id INT,
                permission_name VARCHAR(255)
            );
            
            INSERT INTO user_roles (user_id, role_id) VALUES (1, 1);
            INSERT INTO role_permissions (role_id, permission_id) VALUES (1, 1);
            INSERT INTO permissions (permission_id, permission_name) VALUES (1, 'permission1');
        ");

        $hasPermission = $this->permissionsRepository->userRoleHasPermission(1, 'permission1');
        $this->assertTrue($hasPermission);

        // Test case 2: User does not have the required permission
        $this->pdo->exec("
            DELETE FROM user_roles;
            DELETE FROM role_permissions;
            DELETE FROM permissions;
            
            INSERT INTO user_roles (user_id, role_id) VALUES (1, 2);
            INSERT INTO role_permissions (role_id, permission_id) VALUES (2, 2);
            INSERT INTO permissions (permission_id, permission_name) VALUES (2, 'permission2');
        ");

        $hasPermission = $this->permissionsRepository->userRoleHasPermission(1, 'permission1');
        $this->assertFalse($hasPermission);

        // Test case 3: User ID does not exist
        $hasPermission = $this->permissionsRepository->userRoleHasPermission(999, 'permission1');
        $this->assertFalse($hasPermission);

        // Test case 4: Required permission does not exist
        $hasPermission = $this->permissionsRepository->userRoleHasPermission(1, 'nonexistent_permission');
        $this->assertFalse($hasPermission);
    }
}
