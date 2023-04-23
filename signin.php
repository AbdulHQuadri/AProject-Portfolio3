<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>AProject</title>
</head>
</head>
<body>
<?php
    if(isset($_POST['submitted'])){
        if( !isset($_POST['username'],$_POST['password']) ){
            exit("Please fill both the username and password fields");
        }
        try{
            require_once('connectdb.php');
            $stat = $db->prepare('SELECT password FROM users WHERE username = ?');
            $stat -> execute(array($_POST['username']));

            if($stat -> rowCount()>0){
                $row=$stat->fetch();

                if(password_verify($_POST['password'],$row['password'])){
                    session_start();
                    $_SESSION['username'] = $_POST['username'];
                    header("Location:index.php");
                    exit();
                } else{
                    echo "<p style='color:red'> Error logging in, passwords do not match </p>";
                }
            }else{
                echo "<p>Error username wasn't found</p>";
            }
        } catch(PDOException $ex){
            echo("Failed to connect to the database <br>");
            echo($ex->getMessage());
            exit;

        }

    }

    ?>
    
    <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            <form action="signin.php" method="post">
              <div class="form-floating mb-3">
                 <input type="text" name="username" class="form-control" placeholder="Username">
                <label for="username">Username</label>
              </div>
              
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
              </div>
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign in</button>
                <input type="hidden" name="submitted">
              </div>
              <hr class="my-4">
              <div class="form-floating mb-3">
                <a href='register.php'>Need to sign up?</a>
              </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>