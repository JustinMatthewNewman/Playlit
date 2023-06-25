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

?>


<?php
            /* Database credentials. Assuming you are running MySQL
        server with default setting (user 'root' with no password) */
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


// Define variables and initialize with empty values
$name = $des = "";
$name_err = $des_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Validate name
        if(empty(trim($_POST["name"]))){
            $name_err = "Please enter a name.";
        } else{
            $name = trim($_POST["name"]);
        }

        // Validate name
        if(empty(trim($_POST["des"]))){
          $des_err = "Please enter a description.";
        } else{
            $des = trim($_POST["des"]);
        }

    
    // Check input errors before inserting in database
    if(empty($name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO playlist (name, user_id, description) VALUES (?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sds", $param_name, $param_id, $param_des);
            
            $param_name = $name;
            $param_id = $_SESSION["id"];
            $param_des = $des;
  
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
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
  background: #000 url(images/loader.gif) no-repeat center center;
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


        <!-- <a href="new_playlist.php" class="font-medium">Create Playlist</a> -->


        <!-- Trigger the modal with a button -->
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        + PLAYLIT
        </button>           





<style>
  .modal-content{
    background-color: #202020;
  }
</style>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Playlist</h5>
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
                <span class="input-group-text" id="inputGroup-sizing-lg">Description</span>
              </div>
              <input type="text" name="des" class="form-control <?php echo (!empty($des_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $des; ?>">
                <span class="invalid-feedback"><?php echo $des_err; ?></span>
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
      </style>
      
      <!-- <div class="mx-auto my-5 h-[250px] w-11/12 bg-white bg-[url('https://images.unsplash.com/photo-1662560884455-e89e8dcfa7ea?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80')]"></div> -->

      <section class="song-section mb-6">
        <div class="mb-4 flex justify-between py-3">
          <h1 class="text-3xl font-bold text-white">Playlit🔥</h1>
          <h1 class="text-white/50">Create a new mix!</h1>
        </div>

        <div class="flex flex-wrap gap-3">
        
         
   


      <style> 
    body {
	margin: 0;
	padding: 0;
	background: #642B73;  /* fallback for old browsers */
	background: -webkit-linear-gradient(to right, #C6426E, #642B73);  /* Chrome 10-25, Safari 5.1-6 */
	background: linear-gradient(to right, #C6426E, #642B73); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	font-family: spotify-circular,Helvetica Neue,Helvetica,Arial,Hiragino Kaku Gothic Pro,Meiryo,MS Gothic,sans-serif;
}
.wrapper {
	margin-top: 50px;
}
.wrapper_section_2 {
	margin-top: 10px;
}
.wrapper h1 {
	color: #fff;
	text-align: center;
	font-weight: bold;
}
.cards {
	display: flex;
	flex-wrap: wrap;
	flex-direction: row;
	justify-content: center;
}
.card {
	width: 190px;
	height: 180px;
	margin: 15px;
	position: relative;
	min-width: 190px;
	background: #000;
}
.card:hover .overlayer {
	visibility: visible;
}
.card img {
	width: 100%;
	height: 100%;
}
.card .title  {
	width: 100%;
	height: 30px;
	text-align: center;
	margin-top: 180px;
}

.card .title a {
	top: -175px;
	color: #fff;
	position: relative;
	font-size: 13px;
	text-decoration: none;
}

.card .overlayer {
	top: 0;
	right: 0;
	width: 100%;
	height: 100%;
	position: absolute;
	background: rgba(0,0,0,0.6);
	text-align: center;
	visibility: hidden;
}

.overlayer .fa-play-circle {
	color: #fff;
	font-size: 73px;
	margin-top: 53px;
	transition: 100ms ease-in-out;
}
.fa-play-circle:hover {
	transform: scale(1.1);
}



/*  FOLLOW*/
.Follow {	  background:url("https://pbs.twimg.com/profile_images/959092900708544512/v4Db9QRv_bigger.jpg")no-repeat center / contain;
	width: 50px;
	height: 50px;
	bottom: 9px;
	right: 20px;
	display:block;
	position:fixed;
	border-radius:50%;
	z-index:999;
	animation:  rotation 10s infinite linear;
	}

@-webkit-keyframes rotation {
		from {
				-webkit-transform: rotate(0deg);
		}
		to {
				-webkit-transform: rotate(359deg);
		}
}



    </style>

          <div class="wrapper">
	<h1>Supercharge the week</h1>
	<div class="cards">
		
		<div class="card">
			<div class="overlayer">
				<i class="far fa-play-circle"></i>
			</div>
			<img src="https://i.pinimg.com/736x/02/b8/94/02b894f7ea6ad9f724648ee511ad018f--edm-music-house-music.jpg" alt="">
			<div class="title">
				<a href="#">Hover over</a>
			</div>
		</div>	
		
		
		<div class="card">
			<div class="overlayer">
				<i class="far fa-play-circle"></i>
			</div>
			<img src="https://altwall.net/img/albums/adb1c0cbab29b842b28e6aa1e8e57f47_2013.jpg" alt="">
			<div class="title">
				<a href="#">Hover over</a>
			</div>
		</div>	
		
		<div class="card">
			<div class="overlayer">
				<i class="far fa-play-circle"></i>
			</div>
			<img src="https://is4-ssl.mzstatic.com/image/thumb/Music7/v4/4b/06/29/4b062955-ecce-e362-78f1-025f18eed20a/source/1200x1200bb.jpg" alt="">
			<div class="title">
				<a href="#">Hover over</a>
			</div>
		</div>	
		
		<div class="card">
			<div class="overlayer">
				<i class="far fa-play-circle"></i>
			</div>
			<img src="https://media1.popsugar-assets.com/files/thumbor/L-VT9k0GKckWWnpo3n2YBq4f9tE/fit-in/1024x1024/filters:format_auto-!!-:strip_icc-!!-/2017/08/03/846/n/37139775/2d0d134e5983773fe90560.65157921_edit_img_image_17921777_1501786115/i/Camila-Cabello-Havana-Song.jpg" alt="">
			<div class="title">
				<a href="#">Hover over</a>
			</div>
		</div>		
	</div>
	
	<div class="wrapper_section_2">
	<div class="cards">
		
		<div class="card">
			<div class="overlayer">
				<i class="far fa-play-circle"></i>
			</div>
			<img src="https://media.npr.org/assets/img/2013/04/22/dark-side_sq-1da3a0a7b934f431c175c91396a1606b3adf5c83-s1100-c50.jpg" alt="">
			<div class="title">
				<a href="#">Hover over</a>
			</div>
		</div>	
		
		<div class="card">
			<div class="overlayer">
				<i class="far fa-play-circle"></i>
			</div>
			<img src="https://i.pinimg.com/736x/cf/74/03/cf74032199d378808402329b3765ac72--music-albums-in-color.jpg" alt="">
			<div class="title">
				<a href="#">Hover over</a>
			</div>
		</div>	
		
		<div class="card">
			<div class="overlayer">
				<i class="far fa-play-circle"></i>
			</div>
			<img src="https://i.pinimg.com/736x/ed/b1/10/edb1100257bb6d0ceee624696d9c9f1f--cover-art-album-covers.jpg" alt="">
			<div class="title">
				<a href="#">Hover over</a>
			</div>
		</div>	
		
		<div class="card">
			<div class="overlayer">
				<i class="far fa-play-circle"></i>
			</div>
			<img src="https://i.pinimg.com/736x/00/a1/3c/00a13cf897548091f4042cba761ef00d--cd-cover-dance-music.jpg" alt="">
			<div class="title">
				<a href="#">Hover over</a>
			</div>
		</div>	
		
	</div>
</div>
	

</div>
<article class="song-cover relative h-[290px] w-[210px] overflow-hidden rounded-lg bg-zinc-800/30 hover:bg-zinc-800/90 transition-all p-3 drop-shadow-lg">
          <button class="fade-in absolute top-0 right-4 top-36 rounded-full bg-green-500 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
            </svg>
          </button>
          <img class="h-[60%] w-full object-cover" src="https://images.unsplash.com/photo-1663165850242-f6a0049412cd?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" />
          <h1 class="mt-3 text-white">Artist 1</h1>
          <p class="mt-2 overflow-hidden truncate text-ellipsis text-sm text-white">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aspernatur enim pariatur ut dolore in corporis maiores praesentium nulla dolorum laudantium debitis sapiente, mollitia minima cumque nobis beatae consectetur, a eum.</p>
        </article>

        <article class="song-cover relative h-[290px] w-[210px] overflow-hidden rounded-lg bg-zinc-800/30 hover:bg-zinc-800/90 transition-all p-3 drop-shadow-lg">
          <button class="absolute top-0 right-4 top-36 rounded-full bg-green-500 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
            </svg>
          </button>
          <img class="h-[60%] w-full object-cover" src="https://images.unsplash.com/photo-1641522682563-850550dff807?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80" />
          <h1 class="mt-3 text-white">Artist 1</h1>
          <p class="mt-2 overflow-hidden truncate text-ellipsis text-sm text-white">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aspernatur enim pariatur ut dolore in corporis maiores praesentium nulla dolorum laudantium debitis sapiente, mollitia minima cumque nobis beatae consectetur, a eum.</p>
        </article>

        <article class="song-cover relative h-[290px] w-[210px] overflow-hidden rounded-lg bg-zinc-800/30 hover:bg-zinc-800/90 transition-all p-3 drop-shadow-lg">
          <button class="absolute top-0 right-4 top-36 rounded-full bg-green-500 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
            </svg>
          </button>
          <img class="h-[60%] w-full object-cover" src="https://images.unsplash.com/photo-1663187223787-2ffb84a407fe?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=688&q=80" />
          <h1 class="mt-3 text-white">Artist 1</h1>
          <p class="mt-2 overflow-hidden truncate text-ellipsis text-sm text-white">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aspernatur enim pariatur ut dolore in corporis maiores praesentium nulla dolorum laudantium debitis sapiente, mollitia minima cumque nobis beatae consectetur, a eum.</p>
        </article>

        <article class="song-cover relative h-[290px] w-[210px] overflow-hidden rounded-lg bg-zinc-800/30 hover:bg-zinc-800/90 transition-all p-3 drop-shadow-lg">
          <button class="absolute top-0 right-4 top-36 rounded-full bg-green-500 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
            </svg>
          </button>
          <img class="h-[60%] w-full object-cover" src="https://images.unsplash.com/photo-1641522682419-7e52d83a8ce5?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=697&q=800" />
          <h1 class="mt-3 text-white">Artist 1</h1>
          <p class="mt-2 overflow-hidden truncate text-ellipsis text-sm text-white">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aspernatur enim pariatur ut dolore in corporis maiores praesentium nulla dolorum laudantium debitis sapiente, mollitia minima cumque nobis beatae consectetur, a eum.</p>
        </article>

        <article class="song-cover relative h-[290px] w-[210px] overflow-hidden rounded-lg bg-zinc-800/30 hover:bg-zinc-800/90 transition-all p-3 drop-shadow-lg">
          <button class="absolute top-0 right-4 top-36 rounded-full bg-green-500 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
            </svg>
          </button>
          <img class="h-[60%] w-full object-cover" src="https://images.unsplash.com/photo-1650954913935-05f7a819b745?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80" />
          <h1 class="mt-3 text-white">Artist 1</h1>
          <p class="mt-2 overflow-hidden truncate text-ellipsis text-sm text-white">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aspernatur enim pariatur ut dolore in corporis maiores praesentium nulla dolorum laudantium debitis sapiente, mollitia minima cumque nobis beatae consectetur, a eum.</p>
        </article>

        <article class="song-cover relative h-[290px] w-[210px] overflow-hidden rounded-lg bg-zinc-800/30 hover:bg-zinc-800/90 transition-all p-3 drop-shadow-lg">
          <button class="absolute top-0 right-4 top-36 rounded-full bg-green-500 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
            </svg>
          </button>
          <img class="h-[60%] w-full object-cover" src="https://images.unsplash.com/photo-1620298106068-62c6a8bd05cc?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" />
          <h1 class="mt-3 text-white">Artist 1</h1>
          <p class="mt-2 overflow-hidden truncate text-ellipsis text-sm text-white">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aspernatur enim pariatur ut dolore in corporis maiores praesentium nulla dolorum laudantium debitis sapiente, mollitia minima cumque nobis beatae consectetur, a eum.</p>
        </article>
      </div>
    </section>
      </section>





      
    </div>
  </div>
</section>
<!-- partial -->
  <script src='https://cdn.tailwindcss.com'></script>
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