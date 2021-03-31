<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="style.css" rel="stylesheet" type="text/css"/>


  <nav class="navbar navbar-inverse" id="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" id="navlogo" href="index.php"><span>🍿</span>PopcornDB</a>
    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li><a href="index.php" id="navtext" >Home</a></li>
      <li><a href="movie.php" id="navtext" >Movies</a></li>
      <li><a href="tvshow.php" id="navtext">Tv Shows</a></li>
      <li><a href="myreview.php" id="navtext">Movie Reviews</a></li>
      <li><a href="mytvreview.php" id="navtext">Tv Show Reviews</a></li>
    </ul>
    
    <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" id="hiuser" href="#">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b><span class="caret"></span></a>
          <ul class="dropdown-menu" id="navkodrop">
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="reset-password.php">Reset Your Password</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </li>
    </ul>
  </div>
</div>
</nav>