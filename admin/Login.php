

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">
    <form action="login.php" method="post">
    <h4>Admin Login</h4>
        <?php
        session_start();
        if (isset($_SESSION["admin_registration_successful"])){
            echo "<div class='alert alert-success'>Registration successful! Please log in.</div>";
            unset($_SESSION["admin_registration_successful"]);
        }
        if(isset($_POST["Login"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "../database.php";
            $sql= "SELECT * FROM users WHERE email = '$email' AND role = 'admin'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user){
                if(password_verify($password, $user["password"])){
                    $_SESSION['admin'] = $email;
                    header("Location: dashboard.php");
                   
                    die();
                 }    
                    else{
                        echo "<div class= 'alert alert-danger'>Password does not match</div>";
                    }
                    
               
            } 
                  else{
                        echo "<div class= 'alert alert-danger'>Password does not match</div>";
                    }
        }
        ?>
    
    <div class="group">
            <input type="email" class="form-control" name="email" placeholder="Enter Email:">

        </div>
        <div class="group">
            <input type="password" class="form-control" name="password" placeholder="Password:">

        </div>
        <div class="group_btn">
            <input type="submit" class="btn btn-primary" value="Login"name="Login">

        </div>
    </form>    

    </form>

<!-- <div><p>Not Registered yet? <a href="registration.php" style="text-decoration:none;" >Register Here</a></p></div> -->
    </div>
</body>
</html>