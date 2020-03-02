<?php
// Opens a connection to the database


// Defined as constants so that they can't be changed
DEFINE ('DB_USER', 'root');
//passwd
    DEFINE ('DB_PASSWORD', 'Reaper42@');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'smart_bins');

// $dbc will contain a resource link to the database
// @ keeps the error from showing in the browser

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL: ' .
mysqli_connect_error());

