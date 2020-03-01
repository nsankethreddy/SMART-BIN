<html>
<body>
<?php

session_start();

include_once('connect/mysqli_connect.php');
$errors = array();

$username = "root";
$password = "Reaper42@";
$database = "smart_bins";
$mysqli = new mysqli("localhost", $username, $password, $database);
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
else
{
  $query = "SELECT * FROM bin_info";

  echo '<table border="0" cellspacing="2" cellpadding="2">
       <tr>
           <th> <font face="Arial">User ID</font> </th>
           <th> <font face="Arial">Username</font> </th>
           <th> <font face="Arial">Bin ID</font> </th>
           <th> <font face="Arial">Is Full</font> </th>
           <th> <font face="Arial">Location ID</font> </th>
       </tr>';

  if ($result = $mysqli->query($query)) {
     while ($row = $result->fetch_assoc()) {
         $field1name = $row["user_id"];
         $field2name = $row["username"];
         $field3name = $row["bin_id"];
         $field4name = $row["is_full"];
         $field5name = $row["location_id"];

         echo '<tr>
                   <td>'.$field1name.'</td>
                   <td>'.$field2name.'</td>
                   <td>'.$field3name.'</td>
                   <td>'.$field4name.'</td>
                   <td>'.$field5name.'</td>
               </tr>';
     }
     $result->free();
  }
}

?>
</body>
</html>
