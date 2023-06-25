<!DOCTYPE html>
<html lang="en">

<?php
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

?>
<head>
<link rel="stylesheet" href="./css/login.css">

</head>

<!-- Links to other pages -->

<body>
  <div id="corner2">
    </div>
    <div class="login-box">
      <div id="submit">
        
        <button id="selbtn" class="btn btn-primary" style="height: auto;" type="button"> Select </button>
        <button id="upbtn" class="btn btn-primary" style="height: auto;" type="button"> Upload </button>
        <a href="update_path.php?id=<?php echo $song_id; ?>" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Home</a>
        <a id="profile-pic"><label id="upprogress"></label>
    </div>
  </div>
</div>

</body>

</html>

<script type="module" src="js/profilePhotoUpload.js"></script>
