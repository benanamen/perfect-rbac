<?php declare(strict_types=1);

use PerfectApp\Database\MysqlConnection;
use PerfectApp\RBAC\AuthorizationService;
use PerfectApp\RBAC\PermissionsRepository;
use PerfectApp\RBAC\UserRolesRepository;

require '../vendor/autoload.php';

$config = require './dbConfig.php';
const DB_CONNECTION = 'dev-mysql';
$pdo = (new MysqlConnection())->connect($config[DB_CONNECTION]);

$userRolesRepository = new UserRolesRepository($pdo);
$permissionsRepository = new PermissionsRepository($pdo);
$authorizationService = new AuthorizationService($userRolesRepository);

// Example usage
$userId = 1;
$allowedRoles = ['admin', 'editor'];

// Check if the user's role is authorized
if ($authorizationService->isUserRoleAuthorized($userId, $allowedRoles)) {
    echo "User is authorized!";
} else {
    echo "User is not authorized!";
}

// Example usage for checking permissions
$userId = 1;
$requiredPermission = 'create_post';

// Check if the user's role has the required permission
if ($permissionsRepository->userRoleHasPermission($userId, $requiredPermission)) {
    echo "User has the required permission!";
} else {
    echo "User does not have the required permission!";
}
