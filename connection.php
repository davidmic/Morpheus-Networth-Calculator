<?php
/* team-morpheus Database credentials*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id11002529_root');
define('DB_PASSWORD', '123456');
define('DB_NAME', 'id11002529_team_morpheus');
 
/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>

