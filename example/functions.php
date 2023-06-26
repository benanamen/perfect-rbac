<?php declare(strict_types=1);

function getUserRole(PDO $pdo, int $userId) :mixed
{
    $stmt = $pdo->prepare('SELECT r.role_name FROM user_roles ur
                          JOIN roles r ON ur.role_id = r.role_id
                          WHERE ur.user_id = ?');
    $stmt->execute([$userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return $row['role_name'];
    } else {
        return 'guest'; // Return a default role if user role is not found
    }
}

// Function to check if the user's role is authorized to access the page
function isUserRoleAuthorized(PDO $pdo, int $userId, array $allowedRoles): bool
{
    $userRole = getUserRole($pdo, $userId);
    return in_array($userRole, $allowedRoles);
}

function userRoleHasPermission(PDO $pdo, int $userId, string $requiredPermission)
{
    // Prepare the SQL statement
    $sql = "SELECT COUNT(*) AS count
            FROM user_roles ur
            INNER JOIN role_permissions rp ON ur.role_id = rp.role_id
            INNER JOIN permissions p ON rp.permission_id = p.permission_id
            WHERE ur.user_id = :userId AND p.permission_name = :requiredPermission";

    // Prepare and execute the SQL statement with placeholders
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'userId' => $userId,
        'requiredPermission' => $requiredPermission
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the count is greater than 0 (permission exists for the user's role)
    return $result['count'] > 0;
}
