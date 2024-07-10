<?php
session_start();
if (isset($_SESSION["user"])){
    header("Location: ");
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
        <h4>Admin Registration</h4>
        <?php
        if(isset($_POST["submit"])){
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
          
            $passwordHash= password_hash($password, PASSWORD_DEFAULT);
            

            $errors = array();

          

            if(empty($fullname) OR empty($email) OR empty($password) OR empty($passwordRepeat)){
                array_push($errors,"All fields are required");              
            } 
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email is not valid");
            }
            if(strlen($password)<8){
            array_push($errors, "Password most be atleast 8 character long") ;   
            }
            if($password!==$passwordRepeat){
                array_push($errors, "password does not match");
            }
            require_once "../database.php";
            $sql = "SELECT * FROM users where EMAIL = '$email'";
            $result = mysqli_query($conn, $sql);

            //to check if email already exit
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0){
                array_push($errors, "Email already exist");
            }
            if(count($errors)>0){
              foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
              } 
            }
            else{
               
                $role = "admin";
                $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"ssss",$fullname, $email, $passwordHash, $role);
                    mysqli_stmt_execute($stmt);

                    //after you've been registered it will direct to to Login//
                    $_SESSION['admin_registration_successful']=true;

                    echo "<div class= 'alert alert-success'>You are registered successfully.</div>";
                    header("Location: Login.php");
                } 
                
                else{              
                        die("something went wrong");
                    }
            }
            
        }
        
        
        ?>
    <form action="registration.php" method="post" class="form">
        <div class="group">
            <input type="text" class="form-control" name="fullname" placeholder="fullname:">

        </div>
        <div class="group">
            <input type="email" class="form-control" name="email" placeholder="Email:">

        </div>
        <div class="group">
            <input type="password" class="form-control" name="password" placeholder="Password:">

        </div>
        <div class="group">
            <input type="password" class="form-control" name="repeat_password" placeholder="Confirm password:">

        </div>
        <div class="group_btn">
            <input type="submit" class="btn btn-primary" value="submit"name="submit">

        </div>
    </form>    
    <div><p>Already Registered <a  href="Login.php" style="text-decoration:none;" >Login Here</a></p></div>
</div>        
</body>
</html>