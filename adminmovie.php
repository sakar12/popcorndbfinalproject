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
  if(isset($_REQUEST['searchcode']) && $_REQUEST['searchcode'] == 'search') {
    
  $searchtxt = mysqli_real_escape_string($link, $_POST['searchtxt']);
    $sql = "SELECT * FROM movie WHERE LOWER(title) LIKE LOWER('%$searchtxt%')";

  } else {
    $sql = "SELECT * FROM movie ORDER BY movieid DESC";

  }

  

  $result = mysqli_query($link, $sql);
  include 'adminheader.php';

  if (mysqli_num_rows($result) > 0) {
          // output data of each row
          

?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<style>

* {
  box-sizing: border-box;
}

    .modal-sm{
    color:black;
}

.modal-header{
    background-color:ghostwhite;
    color:black;
}

#x{
    color:black;
}

.modal-dialog{
    position: absolute;
   top: 150px;
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

form{
    position: relative;
    left: 50%;
    top:5%;
    transform: translate(-50%,-50%);
    transition: all 0.5s;
    width: 50px;
    height: 50px;
    background: white;
    box-sizing: border-box;
    border-radius: 25px;
    border: 4px solid white;
    padding: 5px;
}

input{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;;
    height: 42.5px;
    line-height: 30px;
    outline: 0;
    border: 0;
    display: none;
    font-size: 1em;
    border-radius: 20px;
    padding: 0 20px;
}

#searchfa{
    box-sizing: border-box;
    padding: 10px;
    width: 42.5px;
    height: 42.5px;
    position: absolute;
    top: 0;
    right: 0;
    border-radius: 50%;
    color: #07051a;
    text-align: center;
    font-size: 1.2em;
    transition: all 0.1s;
}

form:hover{
    width: 200px;
    cursor: pointer;
}

form:hover input{
    display: block;
}

form:hover #searchfa{
    background: #241627;
    color: white;
}


</style>
<body>
<center>
<h1 style="color:white; font-family: 'Roboto', sans-serif;">Movies</h1>
</center>
<br><br>
<form method="post" id="formsearch" class="search-bar" action="adminmovie.php">   
    <div class="searchBox"> 
      <input type="hidden" name="searchcode" value="search">
        <input type="text" name="searchtxt" name="search" class="searchInput">
        <i class="fa fa-search" id="searchfa"></i>
    </div>
    </form><br>

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
    <a href="adminmovieproductpage.php?movieid=<?php echo $row['movieid'];?>" id="morebtn" class="btn btn-primary" style="margin-bottom:10px;">View More</a>
  </div>
</div>

<?php } ?>
</div>
</div>





<?php 


  } else {
    header("location: adminnoresultmovie.php");
  } //if close

}// isset close
?>

<?php include 'footer.php';?>



</body>
</html>