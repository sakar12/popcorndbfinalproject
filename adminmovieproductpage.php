<?php
// Initialize the session
session_start();
 
require_once "config.php";

if(isset($_POST['submit']) && $_REQUEST['code'] == 'update')
{
  $title = $_POST['title'];
  $year = $_POST['year'];
  $runtime = $_POST['runtime'];
  $genre = $_POST['genre'];
  $plot = mysqli_real_escape_string($link, $_POST['plot']);
  $imdb = mysqli_real_escape_string($link, $_POST['imdb']);
  $movieid = $_POST['movieid'];

  $sql = "UPDATE movie SET title = '$title', year = '$year', runtime = '$runtime', genre = '$genre',plot='$plot', imdb='$imdb' WHERE movieid = '$movieid' ";

  if (mysqli_query($link, $sql)) {
  
  } else {
    
  }
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: adminindex.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'adminheader.php';?>
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

.modal{
  color:black;
}

.modal-header{
    background-color:#351f39;
    color:white;
    border-bottom:1px solid #351f39;
}

.modal-content{
  background-color:black;
  color:white;
  border:none;
}

input{
  color:black;
}

textarea{
  color:black;
}

.modal-footer{
  background-color:#351f39;
  border-top:1px solid #351f39;
}

#x{
    color:white;
}

#editbtn{
  background-color:#1E9E9E;
}

#cancelbtn{
    background-color:black;
    color:white;
    border:none;
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
    <button class="btn btn-primary editbtn" id="editbtn" data-toggle="modal" data-target="#update_modal">Edit</button>
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
    </div>
    
    <div class="modal fade" id="update_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      <form action="" method="POST" >
      
        <div class="modal-header">
          <button type="button" class="close" id="x" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Movie Details</h4>
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <input type="hidden" name="movieid" value="<?php echo $movieid; ?>">
        <div class="modal-body">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>"><br>
        <label for="imdb">Imdb:</label><br>
        <input type="text" id="imdb" name="imdb" value="<?php echo $row['imdb']; ?>"><br>
        <label for="year">Release Date:</label><br>
        <input type="text" id="year" name="year" value="<?php echo $row['year']; ?>"><br>
        <label for="runtime">Runtime:</label><br>
        <input type="text" id="runtime" name="runtime" value="<?php echo $row['runtime']; ?>"><br>
        <label for="genre">Genre:</label><br>
        <input type="text" id="genre" name="genre" value="<?php echo $row['genre']; ?>"><br>
        <label for="plot">Plot:</label><br>
        <textarea type="text"  style="height: 120px; width:250px; " name="plot"><?php echo $row['plot']; ?></textarea><br>

        </div>
        <div class="modal-footer">
        <input type="hidden" name="code" value="update">
        <input type="submit" name ="submit" class="btn btn-primary" value="submit">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form> 
    </div>
  </div>
    
    <hr>

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

</div><br>
<?php 
  } //close while
include 'footer.php';
} //close if
?>
  </body>
</html>



