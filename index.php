<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	

    <!-- Bootstrap CSS -->
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
            	echo '<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>';
            }
            ?>
        </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="<?php echo htmlspecialchars('search'); ?>">
		<button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
		<input type='hidden' name="<?php echo htmlspecialchars('submitted'); ?>">
        
        </form>
    </div>
    </nav>


    <?php


    require_once('connectdb.php');

    
    try{

        if (isset($_GET['submitted'])) {
          $search_query = htmlspecialchars($_GET['search']);
          $stat = $db->prepare("SELECT title, start_date, description, pid, end_date FROM projects WHERE title LIKE :search_query OR end_date LIKE :search_query OR start_date LIKE :search_query");
          $stat->bindValue(':search_query', "%$search_query%", PDO::PARAM_STR);
          $stat->execute();
      } else {
          $stat = $db->query('SELECT title, start_date, description, pid FROM projects;');
      }

      if ($stat->rowCount() > 0) {

        echo '<table class="table">';
        echo '<thead class="thead-light">';
        echo '<tr>';
        echo '<th scope="col">Title</th>';
        echo '<th scope="col">Start</th>';
        echo '<th scope="col">Description</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $stat->fetch()) {
    		echo '<tr>';
    		echo '<td><a href="project.php?id=' . htmlspecialchars($row['pid'], ENT_QUOTES) . '">' . htmlspecialchars($row['title'], ENT_QUOTES) . '</a></td>';
    		echo '<td>' . htmlspecialchars($row['start_date'], ENT_QUOTES) . '</td>';
    		echo '<td>' . htmlspecialchars($row['description'], ENT_QUOTES) . '</td>';
    		echo '</tr>';
		}

        echo '</tbody>';
        // End the HTML table
echo '</table>';
      } else {
          // Display a message if no results were returned
          echo ('No projects found.');
      }
  } catch (PDOException $ex) {
      echo("Failed to connect to the database <br>");
      echo($ex->getMessage());
      exit;
  }

    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>