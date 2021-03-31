<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: adminindex.php");
    exit;
}

require_once "config.php";

if(!isset($_REQUEST['code']))
{

  $sql = "SELECT * FROM movie ORDER BY movieid DESC LIMIT 8";

  

  $result = mysqli_query($link, $sql);

  if (mysqli_num_rows($result) > 0) {
          // output data of each row
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'adminheader.php';?>
</head>
<style>

.card-img-top {
    width: 100%;
    max-height: 18vw;
    object-fit: cover;
}

.card {
  display:inline-block;
  background-color:#241627;
  color:white;
  border:3px solid #241627;
}

.card:hover{
  -ms-transform: scale(1.1); 
  -webkit-transform: scale(1.1); 
  transform: scale(1.1); 
}

#plottext {
   overflow: hidden;
   text-overflow: ellipsis;
   display: -webkit-box;
   -webkit-line-clamp: 1; /* number of lines to show */
   -webkit-box-orient: vertical;
}

@media only screen and (min-width:300px) and (max-width:1200px) {
  .card-img-top {
    width: 100%;
    height: 50vw;
    object-fit: cover;
}

.card {
  text-align:center;
}
}

#morebtn{
  background-color: #1E9E9E;
  color:white;
  border:none;
}

  .card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
}

.card {
  display:inline-block;
  background-color:#241627;
  color:white;
  border:3px solid #241627;
}

.card:hover{
  -ms-transform: scale(1.1); 
  -webkit-transform: scale(1.1); 
  transform: scale(1.1); 
}

@media only screen and (min-width:300px) and (max-width:1200px) {
  .card-img-top {
    width: 100%;
    height: 50vw;
    object-fit: cover;
}

.card {
  text-align:center;
}
}

#morebtn{
  background-color:black;
  color:white;
  border:none;
}

  </style>
<body>

<div class="container-fluid" id="carouselfluid">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="img/avengers.jpeg" style="width:100%;">
      </div>

      <div class="item">
        <img src="img/tenet.jpg" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="img/badboys.jpg" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
<br><br>

<h1 style="color:white; font-family: 'Roboto', sans-serif; margin-left:180px;">New Movies</h1><br>


<div class= "container">
<div class = "row">
<?php 
while ($row = mysqli_fetch_assoc($result)) {
?>

<div class="card col-sm-4" style="width: 25rem; margin-left:30px; margin-right:10px; margin-bottom:60px;">
  <img class="card-img-top" src="img/<?php echo $row['img']; ?>" alt="Card image cap" style="margin-top:10px;">
  <div class="card-body">
    <h5 class="card-title"><?php echo $row['title']; ?></h5>
    <p class="card-text" id="plottext"><?php echo $row['plot']; ?></p>
    <a href="adminmovieproductpage.php?movieid=<?php echo $row['movieid'] ?>;" id="morebtn" class="btn btn-primary" style="margin-bottom:10px;">View More</a>
  </div>
</div>
<?php } ?>
</div>
</div>


<h1 style="color:white; font-family: 'Roboto', sans-serif; margin-left:180px;">New Tv Show</h1><br>
<div class= "container">
<div class = "row">
<?php 
$sql = "SELECT * FROM tvshow ORDER BY tvshowid DESC LIMIT 8";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
?>

<div class="card col-sm-4" style="width: 25rem; margin-left:30px; margin-right:10px; margin-bottom:60px;">
  <img class="card-img-top" src="img/<?php echo $row['img']; ?>" alt="Card image cap" style="margin-top:10px;">
  <div class="card-body">
    <h5 class="card-title"><?php echo $row['title']; ?></h5>
    <p class="card-text" id="plottext"><?php echo $row['plot']; ?></p>
    <a href="admintvproductpage.php?tvshowid=<?php echo $row['tvshowid'] ?>;" id="morebtn" class="btn btn-primary" style="margin-bottom:10px;">View More</a>
  </div>
</div>
<?php } ?>
</div>
</div>


<?php 

  } //if close

}// isset close
?>


<?php include 'footer.php';?>

</body>

</html>