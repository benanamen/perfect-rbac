<?php declare(strict_types=1);

namespace Unit\RBAC;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PerfectApp\RBAC\AuthorizationService;
use PerfectApp\RBAC\UserRolesRepository;

#[CoversClass(AuthorizationService::class)]
class AuthorizationServiceTest extends TestCase
{
    private AuthorizationService $authorizationService;
    private UserRolesRepository $userRolesRepository;

    protected function setUp(): void
    {
        $this->userRolesRepository = $this->createMock(UserRolesRepository::class);
        $this->authorizationService = new AuthorizationService($this->userRolesRepository);
    }

    public function testIsUserRoleAuthorizedReturnsTrueWhenUserRoleIsInAllowedRoles(): void
    {
        $userId = 1;
        $allowedRoles = ['admin', 'editor'];

        $this->userRolesRepository->expects($this->once())
            ->method('getUserRole')
            ->with($userId)
            ->willReturn('admin');

        $result = $this->authorizationService->isUserRoleAuthorized($userId, $allowedRoles);

        $this->assertTrue($result);
    }

    public function testIsUserRoleAuthorizedReturnsFalseWhenUserRoleIsNotInAllowedRoles(): void
    {
        $userId = 1;
        $allowedRoles = ['admin', 'editor'];

        $this->userRolesRepository->expects($this->once())
            ->method('getUserRole')
            ->with($userId)
            ->willReturn('subscriber');

        $result = $this->authorizationService->isUserRoleAuthorized($userId, $allowedRoles);

        $this->assertFalse($result);
    }

    public function testIsUserRoleAuthorizedReturnsFalseWhenUserRolesRepositoryReturnsNull(): void
    {
        $userId = 1;
        $allowedRoles = ['admin', 'editor'];

        $this->userRolesRepository->expects($this->once())
            ->method('getUserRole')
            ->with($userId)
            ->willReturn(null);

        $result = $this->authorizationService->isUserRoleAuthorized($userId, $allowedRoles);

        $this->assertFalse($result);
    }

    public function testIsUserRoleAuthorizedReturnsFalseWhenUserRolesRepositoryThrowsException(): void
    {
        $userId = 1;
        $allowedRoles = ['admin', 'editor'];

        $this->userRolesRepository->expects($this->once())
            ->method('getUserRole')
            ->with($userId)
            ->willThrowException(new \Exception('Failed to fetch user role'));

        $result = $this->authorizationService->isUserRoleAuthorized($userId, $allowedRoles);

        $this->assertFalse($result);
    }

    public function testIsUserRoleAuthorizedReturnsFalseWhenAllowedRolesArrayIsEmptyAndUserRoleIsNull(): void
    {
        $userId = 1;
        $allowedRoles = [];

        $this->userRolesRepository->expects($this->once())
            ->method('getUserRole')
            ->with($userId)
            ->willReturn(null);

        $result = $this->authorizationService->isUserRoleAuthorized($userId, $allowedRoles);

        $this->assertFalse($result);
    }
}