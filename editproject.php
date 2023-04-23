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
	session_start();
	if (!isset($_SESSION['username'])) {
        header('Location: signin.php');
        exit();
    }
    try {
        require_once('connectdb.php');
        // Retrieve the project information using the id parameter from the URL
        $id = intval($_GET['id']);
        $stat = $db->prepare('SELECT title, start_date, end_date, description, phase FROM projects WHERE pid = :id;');
        $stat->bindParam(':id', $id, PDO::PARAM_INT);
        $stat->execute();

        if ($stat->rowCount() > 0) {
            // Display the project information and edit form
            $row = $stat->fetch();
            ?>
            
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                    <h2 class="card-title">View Project</h2>
            		
                    <form action="updateproject.php" method="POST" id='project-form'>
                        <input type="hidden" name="pid" value="<?php echo $id; ?>">
                        <div class="form-group">
                        <label for="project-name">Project Name: </label>
                        <input type="text" class="form-control" id="project-name" aria-describedby="p_name" placeholder="Enter the name of the project: " name="title" value="<?php echo htmlspecialchars($row['title']); ?>">
                        </div>
                        <div class="form-group">
                        <label for="sDate">Start Date: </label>
                        <input type="date" class="form-control" id="sDate" placeholder="Start Date:" name="start_date" value="<?php echo htmlspecialchars($row['start_date']);?>">
                        </div>
                        <div class="form-group">
                        <label for="eDate">End Date: </label>
                        <input type="date" class="form-control" id="eDate" name="end_date" value="<?php echo htmlspecialchars($row['end_date']); ?>">
                        </div>
                        <div class="form-group">
                        <label for="phase-choice">Phase of development: </label>
                        <select class="form-select" aria-label="phase" id='phase-choice' name="phase">
                            <option selected><?php  echo htmlspecialchars($row['phase']);?></option>
                            <option value="1">Design</option>
                            <option value="2">Development</option>
                            <option value="3">Testing</option>
                            <option value="4">Deployment</option>
                            <option value="5">Complete</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" placeholder="" id="description" name="description"><?php echo htmlspecialchars($row['description']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <input type="hidden" name='submitted'>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
            
            <?php
        } else {
            // Display a message if no project was found with the specified id
            echo 'Project not found.';
        }
    } catch (PDOException $e) {
        // Handle database errors here
        echo 'Error: ' . $e->getMessage();
    }
?>

<script src="scripts.js"></script>
</body>
</html>