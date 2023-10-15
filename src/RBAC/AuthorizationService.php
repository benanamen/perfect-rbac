<?php

declare(strict_types=1);

namespace PerfectApp\RBAC;

use Exception;

class AuthorizationService
{
    /**
     * @param UserRolesRepository $userRolesRepository
     */
    public function __construct(private UserRolesRepository $userRolesRepository)
    {
    }

    /**
     * @param int $userId
     * @param array $allowedRoles
     * @return bool
     */
    public function isUserRoleAuthorized(int $userId, array $allowedRoles): bool
    {
        try {
            $userRole = $this->userRolesRepository->getUserRoles($userId);
            return count(array_intersect((array)$userRole, $allowedRoles)) > 0;
        } catch (Exception $exception) {
            error_log('Exception occurred: ' . $exception->getMessage());
            return false;
        }
    }
}
