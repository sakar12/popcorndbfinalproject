<?php
// Initialize the session
session_start();

require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

if(isset($_POST['submit']) && $_REQUEST['code'] == 'updateItem')
{
    $reviewtxt= $_POST['review'];
    $id = $_POST['id']; 
    
  $sql = "UPDATE moviereview SET reviewtxt = '$reviewtxt' WHERE id = '$id' ";

  if (mysqli_query($link, $sql)) {

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
    .modal-sm{
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

.usertable{
    width:80%;
    color:white;
    border-collapse:separate;
    border-spacing:0 10px;
    margin-left:12%; 
    margin-right:15%;
    background-color:#0f0911;
    color:white;
    font-family: 'Roboto', sans-serif;
    font-size:1.8rem;
}

@media only screen and (min-width:300px) and (max-width:1200px) {
  .usertable {
    margin-left:auto; 
    margin-right:auto;
    font-size:1.5rem;
}

}


th{
  border:none !important;
}

td {
  border:none !important;
}

#trhover:hover {
  background-color:#351f39 ;
}

#delete_modal{
  position: absolute;
   top: 40px;
   right: 20px;
   bottom: 0;
   left: 0;
   z-index: 10040;
   overflow: auto;
   overflow-y: auto;
}

#subbtn{
  background-color: #1E9E9E;
  color:white;
  border:none;
}

#editbtn{
  background-color: #1E9E9E;
  color:white;
  border:none;
}

#delbtn{
  background-color:#9E1E1E;
  color:white;
  border:none;
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

#tableimg{
  width: 100px;
  height:100px;
  border-radius: 80%;
  object-fit:fill;
}

#x{
    color:white;
}


</style>
<body>
<center>
<h1 style="color:white; font-family: 'Roboto', sans-serif;">Movie Reviews</h1>
</center>
<br><br>

  
  <?php 
  $username = $_SESSION['username'];
$sql = "SELECT * FROM movie INNER JOIN moviereview ON movie.movieid=moviereview.movieid WHERE username ='$username' ORDER BY createdAt DESC";
$result = mysqli_query($link, $sql);

  if (mysqli_num_rows($result) > 0) {
      
while ($row = mysqli_fetch_assoc($result)) {
?>

<div style="overflow-x:auto;">
<table class="table usertable">
  <thead>
    <tr>
      <th scope="col">Movie Name</th>
      <th scope="col">Movie Year</th>
      <th scope="col">Review</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  
    <tr id="trhover">
    
      <td><?php echo $row['title']; ?></td>
      <td><?php echo $row['year']; ?></td>
      <td><?php echo $row['reviewtxt']; ?></td>
      
      <td><button class="btn btn-primary" id="editbtn" data-toggle="modal" data-target="#update_modal<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-edit"></button></td>
      <td><button class="btn btn-primary btn-danger" id="delbtn" data-toggle="modal" data-target="#delete_modal<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-trash"></button></td> 
    </tr>

    <div id="delete_modal<?php echo $row['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Review</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you would like to delete this review?</p>
      </div>
      <div class="modal-footer">
      <form action="delete-process.php">
      <input type="hidden" name="code" value="removeReviewtxt">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="delbtn" class="btn btn-default btn-danger">Delete</button>
      </div>
      </form>
    </div>

  </div>
</div>

<div class="modal fade" id="update_modal<?php echo $row['id']; ?>" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
      <input type="hidden" name="code" value="updateItem">
        <div class="modal-header">
          <button type="button" class="close" id="x" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Profile</h4>
        </div>
    
        <div class="modal-body">

        <label for="firstname">Review</label><br>
        <textarea type="text" id="review" style="height: 60px; width:150px; " name="review" value=""><?php echo $row['reviewtxt']; ?></textarea><br>
        </div>
        <div class="modal-footer">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <input type="submit" id="subbtn" name ="submit" class="btn btn-primary" value="Submit">
        </div>
      </div>
    </form> 
    </div>
  </div>
  </tbody>
  
  <?php }  ?>
  </table>
  </div>
  <?php 


}?>






<br><br><br><br><br><br><br><br><br><br><br><br>



<?php include 'footer.php';?>




</body>
</html>