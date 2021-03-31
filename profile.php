<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

require_once "config.php";

if(isset($_POST['submit']) && $_REQUEST['code'] == 'update')
{
  $username = $_SESSION['username'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone'  WHERE username = '$username' ";

  if (mysqli_query($link, $sql)) {

  } else {
  }
}

if(isset($_POST['submit']) && $_REQUEST['code'] == 'updateImg')
{
  $target_dir = "img";
  $target_file = basename($_FILES["image"]["name"]);
  $username = $_SESSION['username'];

  $sql = "UPDATE users SET img='$target_file' WHERE username = '$username' ";
  
  if(mysqli_query($link,$sql)){
    move_uploaded_file($_FILES["image"]["tmp_name"], "$target_dir/$target_file");
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
    .imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  filter: brightness(90%);
  width: 18%;
}

h3{
    font-family: 'Caveat', cursive;
    font-family: 'Roboto', sans-serif;
}

.noBorder {
    border:none !important;
}

.table{
    margin-left: 180px;
}

@media only screen and (min-width:300px) and (max-width:1200px) {
    .table{
        margin-left: 60px;
    }
}


.editbtn {
	float: right;
    margin-top:-40px;
    background-color:black;
    color:white;
    border:1px solid black;
}

.editbtn:hover{
    background-color:black;
    color:white;
    border:1px solid white;
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

.avatar{  
  height:200px;
  border-radius: 60%;
  object-fit:fill;
}

#editpic{
  cursor:pointer;
  color:white;
  text-decoration:none;
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

</style>
<body>
<?php
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username' ";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
?>

<div class="container contprofile">
        <center>
         <h2 class="alignleft">My Profile</h2><br> 
         <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#update_modal">Edit</button>
         <figure>
         <img src="img/<?php echo $row['img']; ?>" class="avatar">
         <figcaption><a data-toggle="modal" id="editpic" data-target="#update_modalimg">Change avatar</a></figcaption>
         </figure>   
          <br>
         <table class="table" style="width:60%;">
        <thead>
        <tr>
        <th class="noBorder" scope="col"><h3>Username</h3></th>
        <th class="noBorder" scope="col"><h3><?php echo $row['username']; ?></h3></th>
        </tr>
        </thead>
            <tbody>
            <tr>
            <td class="noBorder"><h3>First Name</h3></td>
            <td class="noBorder"><h3><?php echo $row['firstname']; ?></h3></td>
            </tr>
            <tr>
            <td class="noBorder"><h3>Last Name</h3></td>
            <td class="noBorder"><h3><?php echo $row['lastname']; ?></h3></td>
            </tr>
            <tr>
            <td class="noBorder"><h3>Email</h3></td>
            <td class="noBorder"><h3><?php echo $row['email']; ?></h3></td>
            </tr>
            <tr>
            <td class="noBorder"><h3>Phone</h3></td>
            <td class="noBorder"><h3><?php echo $row['phone']; ?></h3></td>
            </tr>
            </tbody>
            </table>
        </center>

        <div class="modal fade" id="update_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="x" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Profile</h4>
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <div class="modal-body">
        <label for="username">Username:</label><br>
        <h5 name="username"><?php echo htmlspecialchars($_SESSION["username"]); ?></h5>
        <label for="firstname">First name:</label><br>
        <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>"><br>
        <label for="lastname">Last name:</label><br>
        <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>"><br>
        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>"><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>"><br>
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


  <div class="modal fade" id="update_modalimg" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="x" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Avatar</h4>
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
        <div class="modal-body">
        <input type="file" name="image" class="form-control">
        </div>
        <div class="modal-footer">
        <input type="hidden" name="code" value="updateImg">
        <input type="submit" name ="submit" class="btn btn-primary" value="Upload">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form> 
    </div>
  </div>
</div>


<?php 
//end of while loop
}
include 'footer.php';?>



</body>
</html>