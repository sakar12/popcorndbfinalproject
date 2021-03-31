<?php
// Initialize the session
session_start();
 
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

if(isset($_POST['submit']))
{
  $username = $_SESSION['username'];
  $movieid =  $_POST['movieid'];
  $reviewtxt = mysqli_real_escape_string($link, $_POST['reviewtxt']);

  $sql = "INSERT INTO moviereview (username, movieid, reviewtxt) VALUES ('$username', '$movieid' ,'$reviewtxt')";

  $res = mysqli_query($link,$sql);


  if ($res) {
    header("Location: movieproductpage.php?movieid=$movieid");
  } else {
  }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'header.php';?>
</head>
<style>

#movietvproductimg{
  width: 60%;
  height: auto;
  min-height: 100%;
  min-width: 100px;
}

#reviewsproductimg{
  float:left;  
  width: 20%;
  height:120px;
  border-radius: 60%;
  object-fit:fill;
}

.review{
    margin-left: 220px;
    margin-top:-100px;
}

.btnreview{
    background-color:#214151;
    color:white;
    font-size: 15px;
    border:none;
}

.cont4{
    color:white;
}

#yourreview:focus {
    outline: none !important;
    border:5px solid #214151;
    box-shadow: 0 0 10px #719ECE;
}

.editbtn {
	  float: right;
    margin-top:-10px;
    background-color:blue;
    color:white;
    border:1px solid black;
}

.imdb{
  background-color:#ffc90d;
  color:black;
  font-family: 'Oswald', sans-serif;
  height: 10px;
  width: 45px;
  text-align: center;
  font-size: 18px;
  padding: 0px 0px 28px 0px;
}

.imdb:hover{
  background-color:#ffc90d;
  color:black;
}

</style>

  <body>

  <?php 
  $movieid = $_GET['movieid'];
  $sql = "SELECT * FROM movie WHERE movieid='$movieid'";
  $result = mysqli_query($link, $sql);

  if (mysqli_num_rows($result) > 0) {
          // output data of each row
  while ($row = mysqli_fetch_assoc($result)) {
  ?>

    <br>
<div class="container cont4"><br>
    <div class="row">
      <div class="col-md-6">
        <img class="img-thumbnail img-responsive" id="movietvproductimg" src="img/<?php echo $row['img']; ?>" style="margin-left:100px;">
      </div>
        
      <div class="col-md-6" id="movietvproducttitle" >
        <h2><?php echo $row['title']; ?></h2>
        <a class="btn btn-primary imdb" href="<?php echo $row['imdb']; ?>"><strong>IMDb</strong></a>
        <h4>Release Date: <?php echo $row['year']; ?></h4>
        <h4>Runtime: <?php echo $row['runtime']; ?></h4>
        <h4>Genre: <?php echo $row['genre']; ?></h4>
        <h4>Plot:<br><br><?php echo $row['plot']; ?></h4>
        </div>
    </div><hr>

    <div class="row">
    <div class="col-md-6" style="margin-left:100px;">
        <h2>Reviews</h2>
      </div>
    </div>  
    

    <?php 
  $movieid1 = $_GET['movieid'];
  $sql1 = "SELECT * FROM moviereview INNER JOIN users ON moviereview.username=users.username WHERE moviereview.movieid='$movieid1'";
  $result1 = mysqli_query($link, $sql1);

  if (mysqli_num_rows($result1) > 0) {
          // output data of each row
  while ($row1 = mysqli_fetch_assoc($result1)) {
  ?>
    <div class="row">
    <div class="col-md-6" style="margin-left:100px; border:none;">
        <img class="img-responsive" id="reviewsproductimg" src="img/<?php echo $row1['img']; ?>">
      </div>

      <div class="col-md-6 review">
        <strong><p><?php echo $row1['username'];?></p></strong>  
        <p><?php echo $row1['reviewtxt'];?></p>
        <p><?php echo $row1['createdAt'];?></p>
      </div>
    </div>

    <br><br>
 <?php 
  } //if for review
    }  //while for review ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
    <input type="hidden" name="movieid" value="<?php echo $row['movieid']; ?>">
    <div class="row">
    <div class="form-group" style= "width:50%;margin-left:118px;">
  <label for="exampleFormControlTextarea3"></label>
  <textarea class="form-control" name="reviewtxt" id="yourreview" placeholder="Write your review" rows="7"></textarea>
    </div>
    </div>
    
    <div class="row">
    <div class="col-md-6" style="margin-left:100px; border:none;">
    <input class="btn btn-primary" type="submit" name="submit" value="submit" style="background-color: #1E9E9E;">
      </div>
        </div><br>
</div><br>
</form>
<?php 
  } //close while
include 'footer.php';
} //close if
?>
  </body>
</html>

