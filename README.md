[![codecov](https://codecov.io/gh/benanamen/perfect-rbac/branch/master/graph/badge.svg?token=1tzaTyYdlj)](https://codecov.io/gh/benanamen/perfect-rbac)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/benanamen/perfect-rbac/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/benanamen/perfect-rbac/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/benanamen/perfect-rbac/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/benanamen/perfect-rbac/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/benanamen/perfect-rbac/badges/build.png?b=master)](https://scrutinizer-ci.com/g/benanamen/perfect-rbac/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/benanamen/perfect-rbac/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=coverage)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=sqale_index)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)

[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=bugs)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-rbac&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-rbac)

# RBAC Authorization Service Documentation

The RBAC (Role-Based Access Control) Authorization Service provides a simple and effective way to implement role-based access control in your PHP application. This documentation will guide you on how to use the RBAC classes and their methods to perform user role authorization and permission checks.

## Prerequisites

Before using the RBAC Authorization Service, make sure you have the following:

- PHP installed on your system
- PDO extension enabled (for database connectivity)
- A database with the required tables (user_roles, roles, role_permissions, and permissions) populated with relevant data

## Class Overview

The RBAC Authorization Service consists of the following classes:

- `AuthorizationService`: Provides methods to check if a user role is authorized based on a set of allowed roles.
- `PermissionsRepository`: Handles the retrieval of permissions for user roles from the database.
- `UserRolesRepository`: Handles the retrieval of user roles from the database.

## Getting Started

To start using the RBAC Authorization Service, follow these steps:

1. Include the necessary RBAC classes in your PHP file:

```php
use PerfectApp\RBAC\AuthorizationService;
use PerfectApp\RBAC\PermissionsRepository;
use PerfectApp\RBAC\UserRolesRepository;
```

2. Create an instance of the `PDO` class with the appropriate database connection details.

```php
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
```

3. Create instances of the `PermissionsRepository` and `UserRolesRepository` classes, passing the `PDO` instance to their constructors.

```php
$permissionsRepository = new PermissionsRepository($pdo);
$userRolesRepository = new UserRolesRepository($pdo);
```

4. Create an instance of the `AuthorizationService` class, passing the `UserRolesRepository` instance to its constructor.

```php
$authorizationService = new AuthorizationService($userRolesRepository);
```

5. You are now ready to use the RBAC Authorization Service in your application.

## Checking User Role Authorization

The `AuthorizationService` class provides the `isUserRoleAuthorized` method to check if a user role is authorized based on a set of allowed roles.

```php
/**
 * @param int $userId
 * @param array<mixed> $allowedRoles
 * @return bool
 */
public function isUserRoleAuthorized(int $userId, array $allowedRoles): bool
```

### Parameters

- `$userId` (integer): The ID of the user whose role needs to be checked.
- `$allowedRoles` (array): An array of allowed roles. The user's role will be compared against these roles.

### Return Value

- `true` if the user's role matches any of the allowed roles, indicating authorization.
- `false` if the user's role does not match any of the allowed roles or an error occurs.

### Example Usage

```php
$userId = 1;
$allowedRoles = ['admin', 'editor'];

if ($authorizationService->isUserRoleAuthorized($userId, $allowedRoles)) {
    echo "User is authorized.";
} else {
    echo "User is not authorized.";
}
```

## Checking User Role Permissions

The `PermissionsRepository` class provides the `userRoleHasPermission` method to check if a user role has a specific permission.

```php
/**
 * @param int $userId
 * @param string $requiredPermission
 * @return bool
 */
public function userRoleHasPermission(int $userId, string $requiredPermission): bool
```

### Parameters

- `$userId` (integer): The ID of the user whose role's permission needs to be checked.
- `$requiredPermission` (string): The name of the required permission.

### Return Value

- `

true` if the user's role has the required permission.
- `false` if the user's role does not have the required permission or an error occurs.

### Example Usage

```php
$userId = 1;
$requiredPermission = 'edit_post';

if ($permissionsRepository->userRoleHasPermission($userId, $requiredPermission)) {
    echo "User has the required permission.";
} else {
    echo "User does not have the required permission.";
}
```

## Conclusion

You have now learned how to use the RBAC Authorization Service to perform user role authorization and permission checks in your PHP application. By following the provided instructions and examples, you can easily integrate RBAC functionality into your application to control access based on user roles and permissions.