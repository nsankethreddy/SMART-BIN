<?php
// include_once('addUser.php');
// include('connect/mysqli_connect.php');
session_start();

include_once('connect/mysqli_connect.php');
$errors = array();
$username = "";
// $email = "";
// $timezone = date_default_timezone_get();
if(!$dbc){
    echo "Unable to connect";
}

//this checks for basic user input errors like blank fields and non-matching passwords
function validate_form($username,$password,$password_confirm){
    $errors = array();
    $success = 0;

    if (empty($username)) { array_push($errors, "Username is required"); }
    // if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    if ($password != $password_confirm) {
        // echo "password1 : ".$password;
        // echo "password2 : ".$password_confirm;

        array_push($errors, "Passwords do not match");
    }

    return $errors;
    
}

function check_data_errors($username,$password,$password_confirm){

    $errors = array();

    if(strlen($username)<6 || strlen($username > 21)){
        array_push($errors,"Username must be in between 7 and 21 characters ");
    }
    else if(!ctype_alnum($username)){
        array_push($errors,"Username can't contain special symbols ");
    }

    // else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     array_push($errors,"Invalid e-mail format ");
    // }
    else if(strlen($password) <6){
        array_push($errors,"Password must be more than 6 characters");
    }

    return $errors;

}

function check_existing_username($username,$dbc){

    $errors = array();
    //now check if the user already exists
    $user_check_query = "SELECT * FROM account WHERE username='$username' LIMIT 1;";
    $result = mysqli_query($dbc, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) { // if user exists
      if ($user['username'] === $username) {
        array_push($errors, "Username already exists");
      }
  
    //   if ($user['email'] === $email && count($errors)!=1 ) {
    //     array_push($errors, "email already exists");
    //   }
    }
    return $errors;
}

function register_user($username,$email,$password,$dbc){
    $password = md5($password);//encrypt the password before saving in the database

          
    // $current_date = date('Y-m-d');


    $query = "INSERT INTO users (user_id,username, password) 
              VALUES(NULL, '$username', '$password');";

    // $query_json = "INSERT INTO player_data VALUES('$username','$default_data');";

    mysqli_query($dbc, $query); 
    // mysqli_query($dbc, $query_json); 

    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    // $_SESSION['user_data'] = $default_data;
    
    // header('location: ../views/start.html');

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
    // $email = mysqli_real_escape_string($dbc, $_POST['email']);
    $password = mysqli_real_escape_string($dbc, $_POST['password']);
    $password_confirm = mysqli_real_escape_string($dbc, $_POST['password_confirm']);
    
    $form_errors = array();$data_errors = array();$name_errors = array();
    //Form validation time
    //Adds all errors to their error arrays
    $form_errors = validate_form($username,$password,$password_confirm);
    if(empty($form_errors)){
        $data_errors = check_data_errors($username,$password,$password_confirm);
    }
    if(empty($form_errors) && empty($data_errors)){
        $name_errors = check_existing_username($username,$dbc);

    }
    
    $errors = $form_errors;
    foreach($data_errors as $error){
        array_push($errors,$error);
    }
    foreach($name_errors as $error){
        array_push($errors,$error);
    }

    trim_data($username,$password);

    if(empty($form_errors) && empty($data_errors) && empty($name_errors)){
        // echo "<p class = 'txt-white'>You have successfully registered</p>";
        // echo "reg:";
        // echo  mysqli_get_host_info($dbc);

        register_user($username,$password,$dbc);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="../css/login.css"> -->
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <!-- <script src="../src/login.js"></script> -->

</head>

<body>

<nav class="navbar navbar-dark navbar-expand-sm fixed-top bg-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="navbar-brand" href="#">
                    <img src="../images/logo.png" height="30" class="d-inline-block align-top" alt="">
                </a>
            </li>
            <li class="nav-item">
                <a href="../views/index.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="../cgi-bin/leaderboards.php" class="nav-link">Leaderboard</a>
            </li>
            <li class="nav-item">
                <a href="../views/FAQ.html" class="nav-link">FAQ</a>
            </li>
            <li class="nav-item">
                <a href="../views/about.html" class="nav-link">About</a>
            </li>
        </ul>

    </nav>

    <form method="POST" action="../cgi-bin/register.php" class="register-box">

        <h1>Sign up</h1>
        <input type="text" id="reg-username" name="username" placeholder="Enter a username">
        <!-- <input type="email" id="reg-email" name="email" placeholder="Enter your email address"> -->
        <input type="password" id="reg-password" name="password" placeholder="Create a password">
        <input type="password" id="reg-password-confirm" name="password_confirm" placeholder="Re-enter password">
        <input type="submit" name="submit" value="Sign Up">
        <a href = "../cgi-bin/login.php" >Already a user? Sign in</a>

    </form>
    <!-- <?php include('regerrors.php'); ?> -->
    <?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
		<script>
			var error = <?php echo json_encode($error) ?>;
		</script>
		<!-- <script src = '../src/error.js'></script> -->
		<script>RegErrorHandler(error);</script>
  	<?php endforeach ?>
  </div>
<?php  endif ?>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>