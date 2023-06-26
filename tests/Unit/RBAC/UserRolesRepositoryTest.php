<?php declare(strict_types=1);

namespace Unit\RBAC;

use PDO;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PerfectApp\RBAC\UserRolesRepository;

#[CoversClass(UserRolesRepository::class)]
class UserRolesRepositoryTest extends TestCase
{
    private PDO $pdo;
    private UserRolesRepository $userRolesRepository;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        // Set up the database schema and data for testing

        $this->userRolesRepository = new UserRolesRepository($this->pdo);
    }

    public function testGetUserRole(): void
    {
        // Test case 1: User role exists
        $this->pdo->exec("
            CREATE TABLE user_roles (
                user_id INT,
                role_id INT
            );
            CREATE TABLE roles (
                role_id INT,
                role_name VARCHAR(255)
            );
            
            INSERT INTO user_roles (user_id, role_id) VALUES (1, 1);
            INSERT INTO roles (role_id, role_name) VALUES (1, 'role1');
        ");

        $userRole = $this->userRolesRepository->getUserRole(1);
        $this->assertSame(['role_name' => 'role1'], $userRole);

        // Test case 2: User role does not exist
        $this->pdo->exec("
            DELETE FROM user_roles;
            DELETE FROM roles;
            
            INSERT INTO user_roles (user_id, role_id) VALUES (1, 2);
            INSERT INTO roles (role_id, role_name) VALUES (2, 'role2');
        ");

        $userRole = $this->userRolesRepository->getUserRole(2);
        $this->assertSame(false, $userRole);

        // Test case 3: User ID does not exist
        $userRole = $this->userRolesRepository->getUserRole(999);
        $this->assertSame(false, $userRole);
    }
}
