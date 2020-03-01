<?php

session_start();
require_once('connect/mysqli_connect.php');
$errors = array();

function process_user(&$username,&$password){

    trim($username);
    trim($password);
    $errors = array();
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    return $errors;

}

function check_user($username,$password,$dbc){
    $errors = array();
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($dbc, $query);
    if (mysqli_num_rows($results) != 1) {
        array_push($errors, "Wrong username/password combination");
    }
    return $errors; 

}
// echo "login : ".$_POST['login']." username : ".$_POST['username']." password :".$_POST['password'];

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($dbc, $_POST['username']);
    $password = mysqli_real_escape_string($dbc, $_POST['password']);
    $username_errors = array();

    $processing_errors = process_user($username,$password);
    if(count($processing_errors) == 0){
        $username_errors = check_user($username,$password,$dbc);
    }

    if(count($username_errors) == 0 && count($processing_errors) == 0){
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        // echo "You are now logged in : ";  
        // include_once("get_player_data.php");
        $username = $_SESSION["username"];
        $query = "SELECT * FROM player_data WHERE username= '$username';";

        $result = mysqli_query($dbc, $query);
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION['user_data']=$user_data['user_data'];
        // echo $user_data['username'];
        // echo $user_data["user_data"];

        $player_data_json = $user_data['user_data'];
        $userdata = $player_data_json;
        header('location: ../views/index.html');
    }
    $errors = $processing_errors;
    if(empty($processing_errors)){
        $errors = $username_errors;

    }

  
}