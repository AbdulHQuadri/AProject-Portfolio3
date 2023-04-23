<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AProject</title>
</head>
<body>
    <?php
        $host = 'localhost';
        $dbname = 'u_220096670_db';
        $username = 'u-220096670';
        $password = 'TMvfrRhGj9MR8Ut';

        try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        }
    ?>
</body>
</html>