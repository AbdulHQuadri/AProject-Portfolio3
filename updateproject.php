<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>AProject</title>
</head>
<body>

    <?php
        require_once('connectdb.php');

        if (isset($_POST['pid'])) {
            $pid = $_POST['pid'];
        
            // Make sure all required form fields are set
            $title = isset($_POST['title']) ? $_POST['title'] : false;
            $sDate = isset($_POST['start_date']) ? $_POST['start_date'] : false;
            $eDate = isset($_POST['end_date']) ? $_POST['end_date'] : false;
            $phase = isset($_POST['phase']) ? $_POST['phase'] : false;
            $description = isset($_POST['description']) ? $_POST['description'] : false;
        
            if ($title && $sDate && $eDate && $phase && $description) {
                // Update the data in the database
                $stmt = $db->prepare("UPDATE projects SET title = :title, start_date = :start_date, end_date = :end_date, phase = :phase, description = :description WHERE pid = :pid");
                $stmt->execute(['title' => $title, 'start_date' => $sDate, 'end_date' => $eDate, 'phase' => $phase, 'description' => $description, 'pid' => $pid]);
                // Redirect the user to the project page
                header('Location: project.php?id=' . $pid);
                exit;
            } else {
                echo "Please fill out all required fields.";
            }
        } else {
            echo "Project not found.";
        }
    ?>
</body>
</html>