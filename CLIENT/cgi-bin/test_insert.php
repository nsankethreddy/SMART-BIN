<?php
// include_once('addUser.php');
// include('connect/mysqli_connect.php');
//session_start();
$servername = "localhost";
$username = "root";
$password = "Reaper42@";
$database = "smart_bins";

$timeout = 0;
$url = "register.php";
$url2 = "login.php";

$uname = $_POST["username"];
$pass1 = $_POST["password"]; 
$pass2 = $_POST["password_confirm"];

if($pass1 === $pass2)
{
  // $mysqli = new mysqli("localhost", $uname, $password, $database);
  $conn = new mysqli($servername,$username,$password,$database);
  if($conn->connect_error)
  {
    echo 'Failed';
  }
  $sql = "INSERT INTO account (userid,username,password) VALUES(3,'$uname','$pass1');";
  if($conn->query($sql) === TRUE)
  {
    echo "<script type='text/javascript'>alert('Thank you for signing up!');</script>";
    echo "<meta http-equiv='refresh' content='$timeout;$url2' />";
  }
  else{
    echo "<script type='text/javascript'>alert('Could not sign up!');</script>";
    echo "<meta http-equiv='refresh' content='$timeout;$url' />";
  }

}
else{
  echo "<script type='text/javascript'>alert('Passwords don't match!');</script>";
  echo "<meta http-equiv='refresh' content='$timeout;$url' />";
}

?>
