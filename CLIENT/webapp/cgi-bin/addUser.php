<?php

session_start();

include_once('connect/mysqli_connect.php');
$errors = array();
$username = "";
$email = "";
$timezone = date_default_timezone_get();
if(!$dbc){
    echo "Unable to connect";
}

//this checks for basic user input errors like blank fields and non-matching passwords
function validate_form($username,$email,$password,$password_confirm){
    $errors = array();
    $success = 0;

    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    if ($password != $password_confirm) {
        // echo "password1 : ".$password;
        // echo "password2 : ".$password_confirm;

        array_push($errors, "Passwords do not match");
    }

    return $errors;
    
}

function check_data_errors($username,$email,$password,$password_confirm){

    $errors = array();

    if(strlen($username)<6 || strlen($username > 21)){
        array_push($errors,"Username must be in between 7 and 21 characters ");
    }
    else if(!ctype_alnum($username)){
        array_push($errors,"Username can't contain special symbols ");
    }

    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors,"Invalid e-mail format ");
    }
    else if(strlen($password) <6){
        array_push($errors,"Password must be more than 6 characters");
    }

    return $errors;

}

function check_existing_username($username,$email,$dbc){

    $errors = array();
    //now check if the user already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1;";
    $result = mysqli_query($dbc, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) { // if user exists
      if ($user['username'] === $username) {
        array_push($errors, "Username already exists");
      }
  
      if ($user['email'] === $email && count($errors)!=1 ) {
        array_push($errors, "email already exists");
      }
    }
    return $errors;
}

function register_user($username,$email,$password,$dbc){
    $password = md5($password);//encrypt the password before saving in the database

          
    $current_date = date('Y-m-d');
    
    $default_data = '{
        "room1": false,
        "room2": false,
        "room3": false,
        "room4": false,
        "room5": false,
        "room6": false,
        "room7": false,
        "room8": false,
        "room9": false,
        "room10": false,
        "PlayerRoom": "room1",
        "codes": {
          "room1": "ab",
          "room2": 23,
          "room3": "c3",
          "room4": 12
        }
      }';

    $query = "INSERT INTO users (user_id,username, password, email, date_created) 
              VALUES(NULL, '$username', '$password','$email','$current_date');";

    $query_json = "INSERT INTO player_data VALUES('$username','$default_data');";

    mysqli_query($dbc, $query); 
    mysqli_query($dbc, $query_json); 

    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    $_SESSION['user_data'] = $default_data;
    
    header('location: ../views/start.html');

}

function trim_data(&$username,&$email,&$password){
    trim($username);
    trim($email);
    trim($password);
}

//main

if(isset($_POST['submit'])){
    //receive all inputs from the form
    $username = mysqli_real_escape_string($dbc, $_POST['username']);
    $email = mysqli_real_escape_string($dbc, $_POST['email']);
    $password = mysqli_real_escape_string($dbc, $_POST['password']);
    $password_confirm = mysqli_real_escape_string($dbc, $_POST['password_confirm']);
    
    $form_errors = array();$data_errors = array();$name_errors = array();
    //Form validation time
    //Adds all errors to their error arrays
    $form_errors = validate_form($username,$email,$password,$password_confirm);
    if(empty($form_errors)){
        $data_errors = check_data_errors($username,$email,$password,$password_confirm);
    }
    if(empty($form_errors) && empty($data_errors)){
        $name_errors = check_existing_username($username,$email,$dbc);

    }
    
    $errors = $form_errors;
    foreach($data_errors as $error){
        array_push($errors,$error);
    }
    foreach($name_errors as $error){
        array_push($errors,$error);
    }

    trim_data($username,$email,$password);

    if(empty($form_errors) && empty($data_errors) && empty($name_errors)){
        // echo "<p class = 'txt-white'>You have successfully registered</p>";
        echo "reg:";
        echo  mysqli_get_host_info($dbc);

        register_user($username,$email,$password,$dbc);
    }
}