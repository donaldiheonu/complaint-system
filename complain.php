<?php
session_start();
if (!isset($_SESSION['complain_user'] )){
    header("Location: ./login.php");
}else{?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
    <body>
    <div class="container">
    <form action="" method="post"> 
        <?php
            // Retrieve values from $_POST array
            if (isset($_POST["submit"])) {
            $full_name = $_POST["full_name"];
            $department = $_POST["department"];
            $faculty = $_POST["faculty"];
            $email = $_POST["email"];
            $phone_number = $_POST["phone_number"];
            $text = $_POST["complaint"];
            }
            require_once "database.php";
            // Insert data into complaint table
            $sql = "INSERT INTO complaint (full_name, department, faculty, email, phone_number, text) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                // Bind the parameters
                if (!empty($full_name) && !empty($department) && !empty($faculty) && !empty($email) && !empty($phone_number) && !empty($text)) {
                    mysqli_stmt_bind_param($stmt, "ssssss", $full_name, $department, $faculty, $email, $phone_number, $text);
                    mysqli_stmt_execute($stmt);
                   
                    
                    echo "<div class= 'alert alert-success'>Complaint submitted successfully!</div>";
                } else {
                    echo "<div class= 'alert alert-danger'>All fields are required!</div>";
                }
                    

            } 
            else{
                        echo "Error: " . mysqli_error($conn);

                    }
        ?>

       
        <div class="group">
             <label for="fullname">Fullname:</label>
            <input type="text" name="full_name" class="form-control" required>
            </div>    
            <div class="group">
             <label for="department">Department:</label>
            <input type="text" name="department" class="form-control" required>
            </div>           
            
           
            <div class="group">
            <label for="faculty">Faculty:</label>
            <input type="text" name="faculty" class="form-control" required>
            </div>
            
            <div class="group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
            </div>
           
            <div class="group">
            <label for="phone">Phone Number:</label>
            <input type="tel" name="phone_number" class="form-control" required>
            </div>
            
            <div class="group">
            <label for="complaint" >Make your Complaint:</label>
            <textarea name="complaint" class="form-control" required></textarea>
            </div>
            <div class="group_btn">
            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
            </div>
        </form>

    </div>
</body>
</html>
<?php } ?>