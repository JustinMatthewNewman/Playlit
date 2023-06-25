<?php
// Initialize the session
session_start();
// Include config file
require_once "config.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


$url = $_SERVER['REQUEST_URI'];
// Use parse_url() function to parse the URL
// and return an associative array which
// contains its various components
$url_components = parse_url($url);

// Use parse_str() function to parse the
// string passed via URL
parse_str($url_components['query'], $params);
    
// Display result
$list_id = intval($params['id']);

?>





<?php
// Initialize the session
session_start();
// Include config file
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'playlit');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


$url = $_SERVER['REQUEST_URI'];
// Use parse_url() function to parse the URL
// and return an associative array which
// contains its various components
$url_components = parse_url($url);

// Use parse_str() function to parse the
// string passed via URL
parse_str($url_components['query'], $params);
    
// Display result
$list_id = intval($params['id']);
// Define variables and initialize with empty values
$name = $key = $url = "";
$name_err = $key_err = $url_err = "";

$bpm = $bpm_err = 0;

$song_id = 0;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Validate name
        if(empty(trim($_POST["name"]))){
            $name_err = "Please enter a name.";
        } else{
            $name = trim($_POST["name"]);
        }

        // Validate name
        if(empty(trim($_POST["key"]))){
          $key_err = "Please enter a key.";
        } else{
            $key = trim($_POST["key"]);
        }

          // Validate name
        if(empty(trim($_POST["bpm"]))){
          $bpm_err = "Please enter a bpm.";
        } else{
            $bpm = trim($_POST["bpm"]);
        }
        // Validate name
        if(empty(trim($_POST["url"]))){
          $url_err = "Please enter a url.";
        } else{
          $url = trim($_POST["url"]);
        }
        
    
    // Check input errors before inserting in database
    if(empty($name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO song (song_name, song_key, song_bpm, file_path) VALUES (?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssds", $param_name, $param_key, $param_bpm, $param_path);
            
            $param_name = $name;
            $param_key = $key;
            $param_bpm = $bpm;
            $param_path = $url;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                //header("location: welcome.php");

                $list_id = $_SESSION['playlist_id'];
                $song_id = mysqli_insert_id($link);

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    $song_id = mysqli_insert_id($link);
    if(empty($name_err)){
      // Prepare an insert statement
      $sql = "INSERT INTO song_playlist (list_id, song_id) VALUES (?,?)";
       
      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "dd", $param_list, $param_song);
          $param_list = $list_id;
          $param_song = $song_id;
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              // Redirect to login page

             header("location: upload.php?id=" . $song_id);
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
          // Close statement
          mysqli_stmt_close($stmt);
      } else {
          echo "Oops! Something went wrong. Please try again later.";
      }
  }
    
    // Close connection
    mysqli_close($link);
}
?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Playlit🔥</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<html lang="en" >
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../dist/style.css">

</head>


<style> 
/* -----
SVG Icons - svgicons.sparkk.fr
----- */

.svg-icon {
  width: 1em;
  height: 1em;
}

.svg-icon path,
.svg-icon polygon,
.svg-icon rect {
  fill: #4691f6;
}

.svg-icon circle {
  stroke: #4691f6;
  stroke-width: 1;
}

#preloader {
  
  background: #000 url(images/loader2.gif) no-repeat center center;
  background-size: 15%;
  height: 100vh;
  width: 100%;
  position: fixed;
  z-index: 100 ;
}

</style>






<body>
  <!-- partial:index.partial.html -->
  
  <div id="preloader"></div>



<section class="relative flex h-screen w-full">


  <div class="h-full w-3/12 min-w-[198px] max-w-[330px] bg-black px-4">
    <div>
      <button class="py-2 px-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 stroke-white">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
        </svg>
      </button>
    </div>
    <ul class="flex flex-col gap-2">
    <li onclick="location.href = 'home.php';"  class="flex cursor-pointer items-center justify-start gap-5 py-3 px-4 text-white/80 transition-all hover:text-white">
    <svg class="svg-icon" viewBox="0 0 20 20">
							<path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path>
						</svg>
        <a href="home.php" class="font-medium">Home</a>
      </li>
      <li onclick="location.href = 'profile.php';"  class="flex cursor-pointer items-center justify-start gap-5 py-3 px-4 text-white/80 transition-all hover:text-white">
      <svg class="svg-icon" viewBox="0 0 20 20">
							<path fill="none" d="M14.023,12.154c1.514-1.192,2.488-3.038,2.488-5.114c0-3.597-2.914-6.512-6.512-6.512
								c-3.597,0-6.512,2.916-6.512,6.512c0,2.076,0.975,3.922,2.489,5.114c-2.714,1.385-4.625,4.117-4.836,7.318h1.186
								c0.229-2.998,2.177-5.512,4.86-6.566c0.853,0.41,1.804,0.646,2.813,0.646c1.01,0,1.961-0.236,2.812-0.646
								c2.684,1.055,4.633,3.568,4.859,6.566h1.188C18.648,16.271,16.736,13.539,14.023,12.154z M10,12.367
								c-2.943,0-5.328-2.385-5.328-5.327c0-2.943,2.385-5.328,5.328-5.328c2.943,0,5.328,2.385,5.328,5.328
								C15.328,9.982,12.943,12.367,10,12.367z"></path>
						</svg>

        <a href="profile.php" class="font-medium">Edit Profile</a>
      </li>
      <li onclick="location.href = 'welcome.php';" class="flex cursor-pointer items-center justify-start gap-5 py-3 px-4 text-white/80 transition-all hover:text-white">
      <svg class="svg-icon" viewBox="0 0 20 20">
							<path fill="none" d="M19.325,1.521c0-0.241-0.113-0.468-0.306-0.614c-0.192-0.146-0.444-0.194-0.675-0.125L8.152,3.699
							C8.137,3.703,8.126,3.714,8.111,3.72C8.06,3.738,8.015,3.765,7.969,3.793C7.928,3.819,7.888,3.84,7.854,3.87
							C7.817,3.903,7.79,3.943,7.76,3.984C7.73,4.023,7.7,4.059,7.679,4.104C7.658,4.146,7.647,4.191,7.635,4.238
							c-0.015,0.051-0.029,0.1-0.032,0.155C7.602,4.407,7.595,4.421,7.595,4.438v9.63c-0.727-0.415-1.652-0.67-2.688-0.67
							c-2.373,0-4.231,1.285-4.231,2.926c0,1.64,1.858,2.926,4.231,2.926c2.37,0,4.226-1.285,4.226-2.926c0-0.019-0.008-0.038-0.008-0.057
							c0-0.013,0.008-0.026,0.008-0.039V5.017l8.654-2.477v8.61c-0.728-0.415-1.655-0.67-2.693-0.67c-2.371,0-4.228,1.286-4.228,2.926
							c0,1.642,1.856,2.926,4.228,2.926c2.373,0,4.231-1.284,4.231-2.926c0-0.018-0.007-0.036-0.007-0.057
							c0-0.012,0.007-0.024,0.007-0.039V1.521z M4.906,17.711c-1.541,0-2.693-0.733-2.693-1.388c0-0.655,1.152-1.388,2.693-1.388
							c1.538,0,2.688,0.732,2.688,1.388C7.595,16.978,6.444,17.711,4.906,17.711z M15.094,14.795c-1.539,0-2.69-0.733-2.69-1.388
							c0-0.655,1.151-1.388,2.69-1.388c1.541,0,2.693,0.733,2.693,1.388C17.787,14.062,16.635,14.795,15.094,14.795z"></path>
						</svg>

        <a href="welcome.php" class="font-medium">Playlist</a>
      </li>
    </ul>

    <ul class="mt-5 flex flex-col gap-2">
      <li class="flex cursor-pointer items-center justify-start gap-5 py-3 px-4 text-white/80 transition-all hover:text-white">


        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          + SONG
        </button>            





<style>
  .modal-content{
    background-color: #202020;
  }
</style>





        
      </li>

      <!-- <li class="flex cursor-pointer items-center justify-start gap-5 py-3 px-4 text-white/80 transition-all hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 rounded bg-gradient-to-t from-blue-400 to-indigo-800 fill-white p-1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>

      </li> -->
    </ul>
    
    <hr class="mt-5 border-white/30" />
  </div>

  <div class="main-content h-[calc(100%-90px)] w-full overflow-y-scroll bg-black/95 py-1">
    <div class="mx-auto h-full w-11/12 py-2">
      <nav class="flex w-full items-start justify-between">
        <div class="flex gap-5">
    
        </div>

        <div class="flex cursor-pointer items-center gap-3 rounded-full bg-black px-4">
          <img class="h-9 w-9 rounded-full object-cover" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" />
          <a href ="profile.php">
          <span class="text-white"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>

        </a>

          <a href="logout.php" class="font-medium">Sign out</a>
        </div>
      </nav>

      <style>
      .h-\[calc\(100\%-90px\)\] {
    height: auto;
}

.bg-green-500 {
    background-color: rgb(1 100 255 / var(--tw-bg-opacity));
}
      </style>
      
      <!-- <div class="mx-auto my-5 h-[250px] w-11/12 bg-white bg-[url('https://images.unsplash.com/photo-1662560884455-e89e8dcfa7ea?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80')]"></div> -->

      <section class="song-section mb-6">
        <div class="mb-4 flex justify-between py-3">
          <!-- <h1 class="text-3xl font-bold text-white">New Music</h1>
          <h1 class="text-white/50">Create a new mix!</h1> -->
        </div>

        <div class="flex flex-wrap gap-3">
      

 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Playlit🔥</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>







<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Song</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">



            <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-lg">Title</span>
              </div>
              <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
               </div>
            </div>    



            <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-lg">Key</span>
              </div>
              <input type="text" name="key" class="form-control <?php echo (!empty($key_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $key; ?>">
                <span class="invalid-feedback"><?php echo $key_err; ?></span>
               </div>
            </div>    



            <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-lg">Bpm</span>
              </div>
              <input type="text" name="bpm" class="form-control <?php echo (!empty($bpm_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $bpm; ?>">
                <span class="invalid-feedback"><?php echo $bpm_err; ?></span>
               </div>
            </div>    



            <div class="form-group" style="visibility: hidden">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-lg">url</span>
              </div>
              <input type="text" name="url" class="form-control <?php echo (!empty($url_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $url; ?>">
                <span class="invalid-feedback"><?php echo $url_err; ?></span>
               </div>
            </div>    

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>    
    </div>
  </div>
</div>




<style>

@import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

*,*:before,*:after{outline:0;-webkit-box-sizing:border-box;box-sizing:border-box;}
input,button{outline:none;}
a,a:hover,a:visited{color:#ddd;text-decoration:none;}
.flex{display:-webkit-flex;display:flex;}
.flex-wrap{display:-webkit-flex;display:flex;-webkit-flex-wrap:wrap;flex-wrap:wrap;}
.flex-align{-webkit-align-items:center;align-items:center;}
.w-full{width:100%;}

/* HTML5 Audio Player with Playlist, source: https://codepen.io/sekedus/pen/ExxjZEz */
#simp button,#simp input,#simp img{border:0;}
#simp{font-size:14px;font-family:"Segoe UI", Tahoma, sans-serif;text-align:initial;line-height:initial;background:#17212b;color:#ddd;margin:0;overflow:hidden; border-radius: 20px;}
#simp .simp-album{padding:20px 25px 5px;}
#simp .simp-album .simp-cover{margin-right:20px;}
#simp .simp-album .simp-cover img{max-width:80px;width:100%;margin:0;padding:0;display:block;}
#simp .simp-album .simp-title{font-size:120%;font-weight:bold;}
#simp .simp-album .simp-artist{font-size:90%;color:#6c7883;}
#simp .simp-controls{padding:15px;}
#simp .simp-controls button{font-size:130%;width:32px;height:32px;background:none;color:#ddd;padding:7px;cursor:pointer;border:0;border-radius:3px;}
#simp .simp-controls button[disabled]{color:#636469;cursor:initial;}
#simp .simp-controls button:not([disabled]):hover{background:#4082bc;color:#fff;}
#simp .simp-controls .simp-prev,#simp .simp-controls .simp-next{font-size:100%;}
#simp .simp-controls .simp-tracker,#simp .simp-controls .simp-volume{flex:1;margin-left:10px;position:relative;}
#simp .simp-controls .simp-buffer {position:absolute;top:50%;right:0;left:0;height:5px;margin-top:-2.5px;border-radius:100px;}
#simp .simp-controls .simp-loading .simp-buffer {-webkit-animation:audio-progress 1s linear infinite;animation:audio-progress 1s linear infinite;background-image: linear-gradient(-45deg, #000 25%, transparent 25%, transparent 50%, #000 50%, #000 75%, transparent 75%, transparent);background-repeat:repeat-x;background-size:25px 25px;color:transparent;}
#simp .simp-controls .simp-time,#simp .simp-controls .simp-others{margin-left:10px;}
#simp .simp-controls .simp-volume{max-width:110px;}
#simp .simp-controls .simp-volume .simp-mute{margin-right:5px;}
#simp .simp-controls .simp-others .simp-active{background:#242f3d;}
#simp .simp-controls .simp-others .simp-shide button{font-size:100%;padding:0;width:24px;height:14px;display:block;}
#simp .simp-controls input[type=range]{-webkit-appearance:none;background:transparent;height:19px;margin:0;width:100%;display:block;position:relative;z-index:2;}
#simp .simp-controls input[type=range]::-webkit-slider-runnable-track{background:rgba(183,197,205,.66);height:5px;border-radius:2.5px;transition:box-shadow .3s ease;position:relative;}
#simp .simp-controls input[type=range]::-moz-range-track{background:rgba(183,197,205,.66);height:5px;border-radius:2.5px;transition:box-shadow .3s ease;position:relative;}
#simp .simp-controls .simp-load .simp-progress::-webkit-slider-runnable-track{background:#2f3841;}
#simp .simp-controls .simp-load .simp-progress::-moz-range-track{background:#2f3841;}
#simp .simp-controls .simp-loading .simp-progress::-webkit-slider-runnable-track{background:rgba(255,255,255,.25);}
#simp .simp-controls .simp-loading .simp-progress::-moz-range-track{background:rgba(255,255,255,.25);}
#simp .simp-controls input[type=range]::-webkit-slider-thumb{-webkit-appearance:none;background:#fff;height:13px;width:13px;margin-top:-4px;cursor:pointer;border-radius:50%;box-shadow:0 1px 1px rgba(0,0,0,.15), 0 0 0 1px rgba(47,52,61,.2);}
#simp .simp-controls input[type=range]::-moz-range-thumb{-webkit-appearance:none;background:#fff;height:13px;width:13px;cursor:pointer;border-radius:50%;box-shadow:0 1px 1px rgba(0,0,0,.15), 0 0 0 1px rgba(47,52,61,.2);}
#simp .simp-footer{padding:10px 10px 12px;font-size:90%;text-align:center;opacity:.7;}
#simp .simp-display{overflow:hidden;max-height:650px;transition:max-height .5s ease-in-out;}
#simp .simp-hide{max-height:0;}
/* playlist */
#simp ul{margin:5px 0 0;padding:0;list-style:none;max-height:245px;}
#simp ul li{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;margin:0;padding:8px 20px;cursor:pointer;}
#simp ul li:last-child{padding-bottom:13px;}
#simp ul li:nth-child(odd){background:#0e1621;}
#simp ul li:hover{background:#242f3d;}
#simp ul li.simp-active{background:#4082bc;color:#fff;}
#simp ul li .simp-desc{font-size:90%;opacity:.5;margin-left:5px;}
/* playlist scrollbar */
#simp ul{overflow-y:auto;overflow-x:hidden;scrollbar-color:#73797f #2f3841;}
#simp ul::-webkit-scrollbar-track{background-color:#2f3841;}
#simp ul::-webkit-scrollbar{width:6px;background-color:#2f3841;}
#simp ul::-webkit-scrollbar-thumb{background-color:#73797f;}
/* progress animation */
@-webkit-keyframes audio-progress{to{background-position:25px 0;}}
@keyframes audio-progress{to{background-position:25px 0;}}
/* mobile */
@media screen and (max-width:480px) {
#simp .simp-controls .simp-volume,#simp .simp-controls .simp-others{display:none;}
#simp .simp-controls .simp-time{margin-right:10px;}
}
@media screen and (max-width:370px) {
#simp .simp-time .simp-slash,#simp .simp-time .end-time{display:none;}
}
#simp{
  margin: 0;
  width: 100%;
}
</style>






<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WaveSurfer Media player</title>
    <link rel="stylesheet" href="/audio/main.css" />
  </head>
  <body>
    <section> 
      <div class="player">
        <div class="thumb">
          <img src="/audio/Parallax.png" alt="" />
        </div>
        <div class="info">
          <div class="detail">
            <div class="title" id="currentSong">
              A
            </div>

            <div id="keyBPM">
              A
            </div>

            <div class="title">
              <div class="time">
                <span id="current">0:00</span> /
                <span id="duration">0:00</span>
              </div>
            </div>
            
            <div class="control">
              <i class="fi-rr-play" id="playPause"></i>
            </div>
          </div>
          <div id="wave"></div>
        </div>
      </div>
    </section>
    <script src="https://unpkg.com/wavesurfer.js"></script>
    <script src="/audio/media.js"></script>
  </body>

  <script>
// window.addEventListener('load', function () {
// var title = document.getElementsByClassName("simp-title");
// var art = document.getElementsByClassName("simp-artist");

// console.log(title[0].innerHTML);
// console.log(art[0].innerHTML);
// document.getElementById("currentSong").innerHTML = title[0].innerHTML;
// document.getElementById("keyBPM").innerHTML = art[0].innerHTML;
// })

</script>







<div class="simple-audio-player" id="simp" data-config='{"shide_top":false,"shide_btm":false,"auto_load":false}'>
  <div class="simp-playlist">
    <ul>
  
      <?php

        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', 'Jmupassword1!');
        define('DB_NAME', 'playlit');
        
        /* Attempt to connect to MySQL database */
        try{
            $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            die("ERROR: Could not connect. " . $e->getMessage());
        }
        $id = $_SESSION['id'];
        $pl_id = $_SESSION['playlist_id'];
        $query = $pdo->prepare("SELECT * from song_playlist WHERE list_id = $list_id");
        $query->execute();
        $data = $query->fetchAll();
        foreach ($data as &$value) {
            
            $query2 = $pdo->prepare("SELECT * from song WHERE song_id = $value[2]");
            $query2->execute();
            $data2 = $query2->fetchAll();

            

            foreach ($data2 as &$value2) {




                echo " <li><span class=\"simp-source\" data-src=\"";
                echo $value2[6];
                echo"\">";
                echo $value2[1];
                echo "</span><span class=\"simp-desc\">";
                echo $value2[2];
                echo " - ";
                echo $value2[4];
                echo "</span></li>";
                
            }
            
        }


    ?>
        </ul>
  </div>
</div>
</body>

















</html>

<script type="module" src="js/profilePhotoUpload.js"></script>


<script>
  /*
Example: https://setstori.blogspot.com/2016/01/nightmareside.html
*/




// Multiple events to a listener
function addEventListener_multi(element, eventNames, handler) {
  var events = eventNames.split(' ');
  events.forEach(e => element.addEventListener(e, handler, false));
}

// Random numbers in a specific range
function getRandom(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

// Position element inside element
function getRelativePos(elm) {
  var pPos = elm.parentNode.getBoundingClientRect(); // parent pos
  var cPos = elm.getBoundingClientRect(); // target pos
  var pos = {};

  pos.top    = cPos.top    - pPos.top + elm.parentNode.scrollTop,
  pos.right  = cPos.right  - pPos.right,
  pos.bottom = cPos.bottom - pPos.bottom,
  pos.left   = cPos.left   - pPos.left;

  return pos;
}

function formatTime(val) {
  var h = 0, m = 0, s;
  val = parseInt(val, 10);
  if (val > 60 * 60) {
   h = parseInt(val / (60 * 60), 10);
   val -= h * 60 * 60;
  }
  if (val > 60) {
   m = parseInt(val / 60, 10);
   val -= m * 60;
  }
  s = val;
  val = (h > 0)? h + ':' : '';
  val += (m > 0)? ((m < 10 && h > 0)? '0' : '') + m + ':' : '0:';
  val += ((s < 10)? '0' : '') + s;
  return val;
}

function simp_initTime() {
  simp_controls.querySelector('.start-time').innerHTML = formatTime(simp_audio.currentTime); //calculate current value time
  if (!simp_isStream) {
    simp_controls.querySelector('.end-time').innerHTML = formatTime(simp_audio.duration); //calculate total value time
    simp_progress.value = simp_audio.currentTime / simp_audio.duration * 100; //progress bar
  }
  
  // ended of the audio
  if (simp_audio.currentTime == simp_audio.duration) {
    simp_controls.querySelector('.simp-plause').classList.remove('fa-pause');
    simp_controls.querySelector('.simp-plause').classList.add('fa-play');
    simp_audio.removeEventListener('timeupdate', simp_initTime);

    
    if (simp_isNext) { //auto load next audio
      var elem;
      simp_a_index++;
      if (simp_a_index == simp_a_url.length) { //repeat all audio
        simp_a_index = 0;
        elem = simp_a_url[0];
      } else {
        elem = simp_a_url[simp_a_index];  
      }
      simp_changeAudio(elem);
      simp_setAlbum(simp_a_index);
    } else {
      simp_isPlaying = false;
    }
  }
}

function simp_initAudio() {
  // if readyState more than 2, audio file has loaded
	simp_isLoaded = simp_audio.readyState == 4 ? true : false;
  simp_isStream = simp_audio.duration == 'Infinity' ? true : false;
  simp_controls.querySelector('.simp-plause').disabled = false;
  simp_progress.disabled = simp_isStream ? true : false;
  if (!simp_isStream) {
    simp_progress.parentNode.classList.remove('simp-load','simp-loading');
    simp_controls.querySelector('.end-time').innerHTML = formatTime(simp_audio.duration);
  }
  simp_audio.addEventListener('timeupdate', simp_initTime); //tracking load progress
  if (simp_isLoaded && simp_isPlaying) simp_audio.play();
  
  // progress bar click event
  addEventListener_multi(simp_progress, 'touchstart mousedown', function(e) {
    if (simp_isStream) {
      e.stopPropagation();
      return false;
    }
    if (simp_audio.readyState == 4) {
      simp_audio.removeEventListener('timeupdate', simp_initTime);
      simp_audio.pause();
    }
  });
  
  addEventListener_multi(simp_progress, 'touchend mouseup', function(e) {
    if (simp_isStream) {
      e.stopPropagation();
      return false;
    }
    if (simp_audio.readyState == 4) {
      simp_audio.currentTime = simp_progress.value * simp_audio.duration / 100;
      simp_audio.addEventListener('timeupdate', simp_initTime);
      if (simp_isPlaying) simp_audio.play();
    }
  });
}

function simp_loadAudio(elem) {
  simp_progress.parentNode.classList.add('simp-loading');
  simp_controls.querySelector('.simp-plause').disabled = true;
  simp_audio.querySelector('source').src = elem.dataset.src;
  simp_audio.load();
  
  simp_audio.volume = parseFloat(simp_v_num / 100); //based on valume input value
  simp_audio.addEventListener('canplaythrough', simp_initAudio); //play audio without stop for buffering
  
  // if audio fails to load, only IE/Edge 9.0 or above
  simp_audio.addEventListener('error', function() {
    alert('Please reload the page.');
  });
}

function simp_setAlbum(index) {
  simp_cover.innerHTML = simp_a_url[index].dataset.cover ? '<div style="background:url(' + simp_a_url[index].dataset.cover + ') no-repeat;background-size:cover;width:80px;height:80px;"></div>' : '<i class="fa fa-music fa-5x"></i>';
  simp_title.innerHTML = simp_source[index].querySelector('.simp-source').innerHTML;
  simp_artist.innerHTML = simp_source[index].querySelector('.simp-desc') ? simp_source[index].querySelector('.simp-desc').innerHTML : '';
}

function simp_changeAudio(elem) {
	simp_isLoaded = false;
  simp_controls.querySelector('.simp-prev').disabled = simp_a_index == 0 ? true : false;
  simp_controls.querySelector('.simp-plause').disabled = simp_auto_load ? true : false;
  simp_controls.querySelector('.simp-next').disabled = simp_a_index == simp_a_url.length-1 ? true : false;
  simp_progress.parentNode.classList.add('simp-load');
  simp_progress.disabled = true;
  simp_progress.value = 0;
  simp_controls.querySelector('.start-time').innerHTML = '00:00';
  simp_controls.querySelector('.end-time').innerHTML = '00:00';
  elem = simp_isRandom && simp_isNext ? simp_a_url[getRandom(0, simp_a_url.length-1)] : elem;
  
  // playlist, audio is running
  for (var i = 0; i < simp_a_url.length; i++) {
    simp_a_url[i].parentNode.classList.remove('simp-active');
    if (simp_a_url[i] == elem) {
      simp_a_index = i;
      simp_a_url[i].parentNode.classList.add('simp-active');
    }
  }
  
  // scrolling to element inside element
  var simp_active = getRelativePos(simp_source[simp_a_index]);
  simp_source[simp_a_index].parentNode.scrollTop = simp_active.top;
  
  if (simp_auto_load || simp_isPlaying) simp_loadAudio(elem);
  
  if (simp_isPlaying) {
    simp_controls.querySelector('.simp-plause').classList.remove('fa-play');
    simp_controls.querySelector('.simp-plause').classList.add('fa-pause');
  }
}

function simp_startScript() {
  ap_simp = document.querySelector('#simp');
  simp_audio = ap_simp.querySelector('#audio');
  simp_album = ap_simp.querySelector('.simp-album');
  simp_cover = simp_album.querySelector('.simp-cover');
  simp_title = simp_album.querySelector('.simp-title');
  simp_artist = simp_album.querySelector('.simp-artist');
  simp_controls = ap_simp.querySelector('.simp-controls');
  simp_progress = simp_controls.querySelector('.simp-progress');
  simp_volume = simp_controls.querySelector('.simp-volume');
  simp_v_slider = simp_volume.querySelector('.simp-v-slider');
  simp_v_num = simp_v_slider.value; //default volume
  simp_others = simp_controls.querySelector('.simp-others');
  simp_auto_load = simp_config.auto_load; //auto load audio file
  
  if (simp_config.shide_top) simp_album.parentNode.classList.toggle('simp-hide');
  if (simp_config.shide_btm) {
    simp_playlist.classList.add('simp-display');
    simp_playlist.classList.toggle('simp-hide');
  }
  
  if (simp_a_url.length <= 1) {
    simp_controls.querySelector('.simp-prev').style.display = 'none';
    simp_controls.querySelector('.simp-next').style.display = 'none';
    simp_others.querySelector('.simp-plext').style.display = 'none';
    simp_others.querySelector('.simp-random').style.display = 'none';
  }

  // Playlist listeners
  simp_source.forEach(function(item, index) {
    if (item.classList.contains('simp-active')) simp_a_index = index; //playlist contains '.simp-active'
    item.addEventListener('click', function() {
      simp_audio.removeEventListener('timeupdate', simp_initTime);
      simp_a_index = index;
      simp_changeAudio(this.querySelector('.simp-source'));
      simp_setAlbum(simp_a_index);
    });
  });
  
  // FIRST AUDIO LOAD =======
  simp_changeAudio(simp_a_url[simp_a_index]);
  simp_setAlbum(simp_a_index);
  // FIRST AUDIO LOAD =======
  
  // Controls listeners
  simp_controls.querySelector('.simp-plauseward').addEventListener('click', function(e) {
    var eles = e.target.classList;
    if (eles.contains('simp-plause')) {
      if (simp_audio.paused) {
        if (!simp_isLoaded) simp_loadAudio(simp_a_url[simp_a_index]);
        simp_audio.play();
        simp_isPlaying = true;
        eles.remove('fa-play');
        eles.add('fa-pause');
      } else {
        simp_audio.pause();
        simp_isPlaying = false;
        eles.remove('fa-pause');
        eles.add('fa-play');
      }
    } else {
      if (eles.contains('simp-prev') && simp_a_index != 0) {
        simp_a_index = simp_a_index-1;
        e.target.disabled = simp_a_index == 0 ? true : false;
      } else if (eles.contains('simp-next') && simp_a_index != simp_a_url.length-1) {
        simp_a_index = simp_a_index+1;
        e.target.disabled = simp_a_index == simp_a_url.length-1 ? true : false;
      }
      simp_audio.removeEventListener('timeupdate', simp_initTime);
      simp_changeAudio(simp_a_url[simp_a_index]);
      simp_setAlbum(simp_a_index);
    }
  });
  
  // Audio volume
  simp_volume.addEventListener('click', function(e) {
    var eles = e.target.classList;
    if (eles.contains('simp-mute')) {
      if (eles.contains('fa-volume-up')) {
        eles.remove('fa-volume-up');
        eles.add('fa-volume-off');
        simp_v_slider.value = 0;
      } else {
        eles.remove('fa-volume-off');
        eles.add('fa-volume-up');
        simp_v_slider.value = simp_v_num;
      }
    } else {
      simp_v_num = simp_v_slider.value;
      if (simp_v_num != 0) {
        simp_controls.querySelector('.simp-mute').classList.remove('fa-volume-off');
        simp_controls.querySelector('.simp-mute').classList.add('fa-volume-up');
      }
    }
    simp_audio.volume = parseFloat(simp_v_slider.value / 100);
  });
  
  // Others
  simp_others.addEventListener('click', function(e) {
    var eles = e.target.classList;
    if (eles.contains('simp-plext')) {
      simp_isNext = simp_isNext && !simp_isRandom ? false : true;
      if (!simp_isRandom) simp_isRanext = simp_isRanext ? false : true;
      eles.contains('simp-active') && !simp_isRandom ? eles.remove('simp-active') : eles.add('simp-active');
    } else if (eles.contains('simp-random')) {
      simp_isRandom = simp_isRandom ? false : true;
      if (simp_isNext && !simp_isRanext) {
        simp_isNext = false;
        simp_others.querySelector('.simp-plext').classList.remove('simp-active');
      } else {
        simp_isNext = true;
        simp_others.querySelector('.simp-plext').classList.add('simp-active');
      }
      eles.contains('simp-active') ? eles.remove('simp-active') : eles.add('simp-active');
    } else if (eles.contains('simp-shide-top')) {
      simp_album.parentNode.classList.toggle('simp-hide');
    } else if (eles.contains('simp-shide-bottom')) {
      simp_playlist.classList.add('simp-display');
      simp_playlist.classList.toggle('simp-hide');
    }
  });
}

// Start simple player
if (document.querySelector('#simp')) {
  var simp_auto_load, simp_audio, simp_album, simp_cover, simp_title, simp_artist, simp_controls, simp_progress, simp_volume, simp_v_slider, simp_v_num, simp_others;
  var ap_simp = document.querySelector('#simp');
  var simp_playlist = ap_simp.querySelector('.simp-playlist');
  var simp_source = simp_playlist.querySelectorAll('li');
  var simp_a_url = simp_playlist.querySelectorAll('[data-src]');
  var simp_a_index = 0;
  var simp_isPlaying = false;
  var simp_isNext = false; //auto play
  var simp_isRandom = false; //play random
  var simp_isRanext = false; //check if before random starts, simp_isNext value is true
  var simp_isStream = false; //radio streaming
  var simp_isLoaded = false; //audio file has loaded
  var simp_config = ap_simp.dataset.config ? JSON.parse(ap_simp.dataset.config) : {
    shide_top: false, //show/hide album
    shide_btm: false, //show/hide playlist
    auto_load: false //auto load audio file
  };
  
  var simp_elem = '';
  simp_elem += '<audio id="audio" preload><source src="" type="audio/mpeg"></audio>';
  simp_elem += '<div class="simp-display"><div class="simp-album w-full flex-wrap"><div class="simp-cover"><i class="fa fa-music fa-5x"></i></div><div class="simp-info"><div class="simp-title">Title</div><div class="simp-artist">Artist</div></div></div></div>';
  simp_elem += '<div class="simp-controls flex-wrap flex-align">';
  simp_elem += '<div class="simp-plauseward flex flex-align"><button type="button" class="simp-prev fa fa-backward" disabled></button><button type="button" class="simp-plause fa fa-play" disabled></button><button type="button" class="simp-next fa fa-forward" disabled></button></div>';
  simp_elem += '<div class="simp-tracker simp-load"><input class="simp-progress" type="range" min="0" max="100" value="0" disabled/><div class="simp-buffer"></div></div>';
  simp_elem += '<div class="simp-time flex flex-align"><span class="start-time">00:00</span><span class="simp-slash">&#160;/&#160;</span><span class="end-time">00:00</span></div>';
  simp_elem += '<div class="simp-volume flex flex-align"><button type="button" class="simp-mute fa fa-volume-up"></button><input class="simp-v-slider" type="range" min="0" max="100" value="100"/></div>';
  simp_elem += '<div class="simp-others flex flex-align"><button type="button" class="simp-plext fa fa-play-circle" title="Auto Play"></button><button type="button" class="simp-random fa fa-random" title="Random"></button><div class="simp-shide"><button type="button" class="simp-shide-top fa fa-caret-up" title="Show/Hide Album"></button><button type="button" class="simp-shide-bottom fa fa-caret-down" title="Show/Hide Playlist"></button></div></div>';
  simp_elem += '</div>'; //simp-controls
  
  var simp_player = document.createElement('div');
  simp_player.classList.add('simp-player');
  simp_player.innerHTML = simp_elem;
  ap_simp.insertBefore(simp_player, simp_playlist);
  simp_startScript();
}
</script>

      
    </div>
  </div>
</section>
<!-- partial -->
  <script src='https://cdn.tailwindcss.com'></script>
  <script>
  const paragraph = document.getElementById("edit");
const edit_button = document.getElementById("edit-button");
const end_button = document.getElementById("end-editing");

edit_button.addEventListener("click", function() {
  paragraph.contentEditable = true;
  paragraph.style.backgroundColor = "#fff";
} );

end_button.addEventListener("click", function() {
  paragraph.contentEditable = false;
  paragraph.style.backgroundColor = "#fff";
} )
</script>

<script> 

var loader = document.getElementById("preloader");
window.addEventListener("load", function() {
  setTimeout(function (){
    loader.style.display = "none";

  // Something you want delayed.
            
}, 1000);
})


</script>


</body>
</html>