<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AProject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: signin.php');
        exit();
    }
    
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">AProject</a>
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
        <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name='search'>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
        <input type='hidden' name='submitted'>
        
        </form>
    </div>
    </nav>

	<div class="card">
  		<div class="card-body">
    		<form action="addproject.php" method="POST" id='project-form'>
        	<div class="form-group">
            	<label for="project-name">Project Name: </label>
            	<input type="text" class="form-control" id="project-name" aria-describedby="p_name" placeholder="Enter the name of the project: " name="name">
        	</div>
        	<div class="form-group">
           		<label for="sDate">Start Date: </label>
            	<input type="date" class="form-control" id="sDate" placeholder="Start Date:" name="start">
        	</div>
        	<div class="form-group">
            	<label for="eDate">End Date: </label>
            	<input type="date" class="form-control" id="eDate" name="end">
        	</div>
        	<div class="form-group">
            	<label for="phase-choice">Phase of development: </label>
            	<select class="form-select" aria-label="phase" id='phase-choice' name="phase">
                	<option selected>Design</option>
                	<option value="1">Development</option>
                	<option value="2">Testing</option>
                	<option value="3">Deployment</option>
                	<option value="4">Complete</option>
            	</select>
        	</div>
        	<div class="form-group">
            	<label for="description">Description:</label>
            	<textarea class="form-control" placeholder="" id="description" name="description"></textarea>
        	</div>
       		<button type="submit" class="btn btn-primary">Submit</button>
        	<input type="hidden" name='submitted'>
    	</form>
  	</div>
	</div> 
    <?php
        require_once('connectdb.php');
    
        if (isset($_POST['submitted'])) {
            // Check if the user is logged in and has a valid session ID
            if (isset($_SESSION['username'])) {
                $user = $_SESSION['username'];
    
                // Retrieve the user's ID from the database based on their session ID
                $stmt = $db->prepare("SELECT uid FROM users WHERE username = ?");
                $stmt->execute([$user]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $user = $row['uid'];
                } else {
                    // Invalid session ID
                    $user = false;
                }
            } else {
                // User is not logged in
                $user = false;
            }
    
            // Make sure all required form fields are set
            $title = isset($_POST['name']) ? $_POST['name'] : false;
            $sDate = isset($_POST['start']) ? $_POST['start'] : false;
            $eDate = isset($_POST['end']) ? $_POST['end'] : false;
            $phase = isset($_POST['phase']) ? $_POST['phase'] : false;
            $description = isset($_POST['description']) ? $_POST['description'] : false;
    
            if ($user && $title && $sDate && $eDate && $phase && $description) {
                // Insert the data into the database
                $stmt = $db->prepare("INSERT INTO projects (title, start_date, end_date, phase, description, uid) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $sDate, $eDate, $phase, $description, $user]);
                // Redirect the user to the project page
                header('Location: index.php?id=' . $db->lastInsertId());
                exit;
            } else {
                echo "Please fill out all required fields.";
            }
        }


        // require_once('connectdb.php');
        // session_start();
        // if (isset($_GET['submitted'])){
        //     try{
        //         $title = isset($_POST['name'])?$_POST['name']:false;
        //         $sDate = isset($_POST['start'])?$_POST['start']:false;
        //         $eDate = isset($_POST['end'])?$_POST['end']:false;
        //         $phase = isset($_POST['phase'])?$_POST['phase']:false;
        //         $description = isset($_POST['description'])?$_POST['description']:false;
        //         $user = isset($_SESSION['uid'])?$_SESSION['uid']:false;
        //         $stat = $db ->prepare("Insert into projects values(default,?,?,?,?,?,?)");
        //         $stat ->execute(array($title,$sDate,$eDate,$phase, $description,$user));
        //     }catch(PDOException $ex){
        //         echo "Sorry a database error occured";
        //         echo "Your details are <em>". $ex->getMessage()."</em>";
        //     }
           
        // }
        
        
               
    ?>
    <script src='scripts.js'></script>

</body>
</html>