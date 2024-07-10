<?php
session_start();
if(isset($_SESSION['admin'])){
    echo "<h1>Admin Dashboard</h1>";
}else{
    header("Location: ./login.php");
}