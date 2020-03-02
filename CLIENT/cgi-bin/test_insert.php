<?php
// include_once('addUser.php');
// include('connect/mysqli_connect.php');
session_start();

$errors = array();
$username = "";
$uname = "root";
$password = "Reaper42@";
$database = "smart_bins";
$mysqli = new mysqli("localhost", $uname, $password, $database);
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
$query = "INSERT INTO account VALUES(NULL,"uname","pass")";
if (mysql_query($query))
{
  echo "Success";
}
else {
  echo "Failed";
}

?>
