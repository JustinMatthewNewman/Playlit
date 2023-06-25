
<?php
// Initialize the session
session_start();
// Include config file
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Jmupassword1!');
define('DB_NAME', 'playlit');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$url = "";
$url_err = "";

$url = $_SERVER['REQUEST_URI'];
// Use parse_url() function to parse the URL
// and return an associative array which
// contains its various components
$url_components = parse_url($url);

// Use parse_str() function to parse the
// string passed via URL
parse_str($url_components['query'], $params);
    
// Display result
$song_id = $params['id'];

try{
    $pdo = new PDO("mysql:host=localhost;
                    dbname=playlit", "root", "Jmupassword1!");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, 
                        PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " 
                    . $e->getMessage());
}
  
try{
    $path = $_COOKIE["url"];
    $sql = "UPDATE song SET file_path='$path' WHERE song_id=$song_id";
    $pdo->exec($sql);
    echo "Records was updated successfully.";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. "
                                . $e->getMessage());
}
unset($pdo);
header("location: welcome.php");
?>