<?php declare(strict_types=1);

use PerfectApp\Database\MysqlConnection;

require '../vendor/autoload.php';

$config = require './dbConfig.php';

//Options: dev-mysql,  prod-mysql, sqlite, postgresql
const DB_CONNECTION = 'dev-mysql';

$pdo = (new MysqlConnection())->connect($config[DB_CONNECTION]);

session_start(); // Start the session

$userId = $_SESSION['user_id'] = 1; // Assuming you have stored the user ID in a session variable

// Check if the user's role is authorized to access the page
if (!isUserRoleAuthorized($pdo, $userId, ['admin', 'manager'])) {
    // User's role is not authorized, redirect to an error page or a different page
    //header('Location: unauthorized.php');
    http_response_code(403); // Set HTTP status code to 403 Forbidden
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Unauthorized</title>
    </head>
    <body>
    <h1>Unauthorized Access</h1>
    <p>Sorry, you do not have permission to access this page.</p>
    </body>
    </html>

    <?php
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Authorized Page</title>
</head>
<body>
<h1>Welcome to the Authorized Page!</h1>
<!-- Page content for authorized users -->
</body>
</html>
