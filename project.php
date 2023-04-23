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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">AProject</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            
            <!-- <li class="nav-item">
                <a class="nav-link active" href="addproject.php">Add project</a>
            </li> -->
            <li>
            <?php
                session_start();
                if (isset($_SESSION['username'])) {
                    // user is logged in, show extra navbar heading for logout
                    echo '<li class="nav-item"><a class="nav-link active" href="addproject.php">Add project</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    
                } else {
                    // user is not logged in, show standard navigation links
                    echo '<li class="nav-item"><a class="nav-link" href="signin.php">Login</a></li>';
                }
                ?>
            </li>
            </ul>

        </div>
    </nav>


    <?php
    try {
        require_once('connectdb.php');
        // Retrieve the project information using the id parameter from the URL
        $id = $_GET['id'];
        $stat = $db->prepare('SELECT title, start_date, end_date, description,phase,uid FROM projects WHERE pid = :id;');
        $stat->bindParam(':id', $id);
        $stat->execute();
	    // fetches the email of the user currently logged in
        $email = $db->prepare('SELECT users.email FROM projects JOIN users ON projects.uid = users.uid WHERE pid = :id;');
        $email->bindParam(':id', $id);
        $email->execute();
        $email_result = $email->fetchColumn();

        if ($stat->rowCount() > 0) {
            // Display the project information
            $row = $stat->fetch();
            }
            
            

         else {
            // Display a message if no project was found with the specified id
            echo 'Project not found.';
        }
    } catch (PDOException $e) {
        // Handle database errors here
        echo 'Error: ' . $e->getMessage();
    }
    ?>
        <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h2 class="card-title"><?php echo $row['title']; ?></h2>
                <p class="card-text"><strong>Start date:</strong> <?php echo $row['start_date']; ?></p>
                <p class="card-text"><strong>End date:</strong> <?php echo $row['end_date']; ?></p>
                <p class="card-text"><strong>Description:</strong> <?php echo $row['description']; ?></p>
                <p class="card-text"><strong>Phase:</strong> <?php echo $row['phase']; ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo $email_result; ?></p>
                <?php if (isset($_SESSION['username'])) { ?>
                    <a href="editproject.php?id=<?php echo $id; ?>" class="btn btn-primary" >Edit this project</a>	
                	<a href="deleteproject.php?id=<?php echo $id; ?>" class='btn btn-danger' onclick="confirmDelete(<?php echo $id; ?>)">Delete Project</a>
                <?php } ?>
                </div>
            </div>
        </div>
	<script src='scripts.js'></script>
</body>
</html>