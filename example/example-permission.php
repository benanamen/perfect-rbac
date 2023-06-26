<?php declare(strict_types=1);

use PerfectApp\Database\MysqlConnection;

require '../vendor/autoload.php';

$config = require './dbConfig.php';

//Options: dev-mysql,  prod-mysql, sqlite, postgresql
const DB_CONNECTION = 'dev-mysql';

$pdo = (new MysqlConnection())->connect($config[DB_CONNECTION]);

// Authenticate the user and retrieve their role from the database
$userId = 1;

// Define the required permission for the action being performed
$requiredPermission = 'create_post';

// Check if the user's role has the required permission
if (userRoleHasPermission($pdo, $userId, $requiredPermission)) {
    // User has the required permission, perform the action
    echo 'Good. Do some action here';
} else {
    // User doesn't have the required permission, display an error message or redirect to an error page
    echo "You don't have permission to perform this action.";
}
