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
        if(isset($_POST['submitted'])){
            require_once('connectdb.php');

            $username = isset($_POST['username'])?$_POST['username']:false;
            $email = isset($_POST['email'])?$_POST['email']:false;
            $password = isset($_POST['password'])?password_hash($_POST['password'],PASSWORD_DEFAULT):false;

            if(!($username)){
                echo "User name is wrong";
                exit;
            }
            if(!($password)){
                exit('password is wrong');
            }
            try{
                $stat = $db ->prepare("Insert into users values(default,?,?,?)");
                $stat ->execute(array($username,$password,$email));

                $id = $db ->lastInsertId();
                echo "Congratulations you are now registered your ID is: " . $id;
                header('Location: index.php');
            } 
            catch(PDOException $ex){
                echo "Sorry a database error occured";
                echo "Your details are <em>". $ex->getMessage()."</em>";
            }
        }
    ?>
    

    <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Register</h5>
            <form action="register.php" method="post">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name='username'>
                <label for="floatingInput">Username</label>
              </div>
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingEmail" placeholder="Email" name="email">
                <label for="floatingEmail">Email address</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
              </div>
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Register</button>
                <input type="hidden" value="true" name='submitted'>
              </div>
              <hr class="my-4">
              <div class="d-grid mb-2">
                <a href="signin.php">Already have an account?</a>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>