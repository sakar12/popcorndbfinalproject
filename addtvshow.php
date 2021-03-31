<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: adminlogin.php");
    exit;
}

require_once "config.php";

if(isset($_POST['submit']))
{
  $title = $_POST['title'];
  $year =  mysqli_real_escape_string($link, $_POST['year']);
  $season = $_POST['season'];
  $genre = $_POST['genre'];
  $plot = mysqli_real_escape_string($link, $_POST['plot']);
  $imdb = mysqli_real_escape_string($link, $_POST['imdb']);

  $target_dir = "img";
  $target_file = basename($_FILES["image"]["name"]);
  if(move_uploaded_file($_FILES["image"]["tmp_name"], "$target_dir/$target_file")){
    header("location: addtvshow.php");
  }else{
    
  }

  $sql = "INSERT INTO tvshow (title, year, season, genre, imdb, plot , img) VALUES ('$title', '$year' ,'$season', '$genre', '$imdb', '$plot','$target_file')";

  $res = mysqli_query($link,$sql);


  if ($res) {
    //header("location: addtvshow.php");
  } else {
    echo "error";
  }
}

if(!isset($_REQUEST['code']))
{

  $sql = "SELECT * FROM tvshow ORDER BY tvshowid DESC";

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
    .modal-sm{
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

.modal-dialog{
    position: absolute;
   top: 100px;
   right: 20px;
   bottom: 0;
   left: 0;
   z-index: 10040;
   overflow: auto;
   overflow-y: auto;
}

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

#delbtn{
  background-color:#9E1E1E;
  color:white;
  border:none;
}

#addbtn{
  background-color:#1E9E9E;
  border:none;
  width: 80px;
  height: 45px;
  font-family: 'Roboto', sans-serif;
  font-size: 24px;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 500;
  border: none;
  border-radius: 45px;
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease 0s;
  cursor: pointer;
  outline: none;
}

#addbtn:hover {
  background-color: #00b33c;
  box-shadow: 0px 15px 20px rgba(46, 229, 157, 0.4);
  color: #fff;
  transform: translateY(-7px);
}

#cancelbtn{
    background-color:black;
    color:white;
    border:none;
}

</style>
<body>
    <center>
    <h1 style="color:white; font-family: 'Roboto', sans-serif;">Add New Tv Show</h1>
    <button class="btn btn-primary" data-toggle="modal" id="addbtn" data-target="#modaltvshow">+</button><br><br><br>

    <div class="modal fade" id="modaltvshow" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="x" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Tv Show</h4>
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
        <div class="modal-body">
        <label for="title">Title</label><br>
        <input type="text" id="title" name="title" value=""><br>
        <label for="year">Year</label><br>
        <input type="text" id="year" name="year" value=""><br>
        <label for="season">Season</label><br>
        <input type="text" id="season" name="season" value=""><br>
        <label for="genre">Genre</label><br>
        <input type="text" id="genre" name="genre" value=""><br>
        <label for="imdb">Imdb</label><br>
        <input type="text" id="imdb" name="imdb" value=""><br>
        <label for="plot">Plot</label><br>
        <textarea type="text" id="plot" style="height: 60px; width:150px; " name="plot" value=""></textarea><br>
        <input type="file" name="image" class="form-control">

        </div>
        <div class="modal-footer">
        <input class="btn btn-primary" type="submit" name="submit" value="submit" style="background-color:#1E9E9E;">
          <button type="button" id="cancelbtn" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
    </div>
  </div>
  </center>

<div class= "container">
<div class = "row">
<?php 
while ($row = mysqli_fetch_assoc($result)) {
?>
<div class="card col-sm-4" style="width: 25rem; margin-left:10px; margin-right:30px; margin-bottom:60px;">
  <img class="card-img-top" src="img/<?php echo $row['img']; ?>" alt="Card image cap" style="margin-top:10px;">
  <div class="card-body">
    <h5 class="card-title"><?php echo $row['title']; ?></h5>
    <p class="card-text" id="plottext"><?php echo $row['plot']; ?></p>
    <a href="admintvproductpage.php?tvshowid=<?php echo $row['tvshowid'] ?>" id="morebtn" class="btn btn-primary" style="margin-bottom:10px;">View More</a>
    <a href="#" id="delbtn" class="btn btn-primary" style="margin-bottom:10px;" data-toggle="modal" data-target="#delete_modal<?php echo $row['tvshowid']; ?>">Delete</a>
  </div>
</div>

<div id="delete_modal<?php echo $row['tvshowid']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Tv Show</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you would like to delete "<?php echo $row['title']; ?>" ?</p>
      </div>
      <div class="modal-footer">
      <form action="delete-process.php">
        <input type="hidden" name="code" value="removeTvshow">
        <input type="hidden" name="tvshowid" value="<?php echo $row['tvshowid']; ?>">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="delbtn" class="btn btn-default btn-danger">Delete</button>
      </div>
      </form>
    </div>

  </div>
</div>

<?php } ?>
</div>
</div>

<?php include 'footer.php';?>

<?php 


  } //if close

}// isset close
?>



</body>
</html>