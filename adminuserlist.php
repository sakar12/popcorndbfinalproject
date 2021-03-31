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
  $temp_id = $_REQUEST['id'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone'  WHERE id = '$temp_id ' ";

  if (mysqli_query($link, $sql)) {
  } else {
  }
}

if(!isset($_REQUEST['code']))
{


  
          // output data of each row

            if(isset($_REQUEST['searchcode']) && $_REQUEST['searchcode'] == 'search') {
              
            $searchtxt = mysqli_real_escape_string($link, $_POST['searchtxt']);
              $sql = "SELECT * FROM users WHERE LOWER(username) LIKE LOWER('%$searchtxt%')";
        
              $result = mysqli_query($link, $sql);

             

            } else {

              $sql = "SELECT * FROM users";

              $result = mysqli_query($link, $sql);

              

          
            }     
            if (mysqli_num_rows($result) > 0) {    
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'adminheader.php';?>
</head>
<style>

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
   top: 200px;
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

#formsearch{
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

#searchinputname{
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

#formsearch:hover{
    width: 200px;
    cursor: pointer;
}

#formsearch:hover input{
    display: block;
}

#formsearch:hover #searchfa{
    background: #241627;
    color: white;
}

</style>
<body>
<center><h1 style="color:white; font-family: 'Roboto', sans-serif;">List of Users</h1></center>
<br><br>

<form method="post" id="formsearch" class="search-bar" action="adminuserlist.php">   
    <div class="searchBox"> 
      <input type="hidden" name="searchcode" value="search">
        <input type="text" name="searchtxt" name="search" class="searchInput" id="searchinputname">
        <i class="fa fa-search" id="searchfa"></i>
    </div>
    </form><br>

<div style="overflow-x:auto;">
<table class="table usertable">
  <thead>
    <tr>
    <th scope="col">Avatar</th>
      <th scope="col">User ID</th>
      <th scope="col">Username</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  
  <tbody>
  <?php 
while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr id="trhover">
      <td style="padding:0px 10px 0px 0px;"><img src="img/<?php echo $row['img']; ?>" class="avatar" id="tableimg"></td>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['firstname']; ?></td>
      <td><?php echo $row['lastname']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['phone']; ?></td>
      <td><button class="btn btn-primary" id="editbtn" data-toggle="modal" data-target="#update_modal<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-edit"></button></td>
      <td><button class="btn btn-primary btn-danger" id="delbtn" data-toggle="modal" data-target="#delete_modal<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-trash"></button></td>
    </tr>

    <div id="delete_modal<?php echo $row['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete User</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you would like to delete this user? <?php echo $row['id']; ?></p>
      </div>
      <div class="modal-footer">
      <form action="delete-process.php">
        <input type="hidden" name="code" value="removeItem">
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
      <form action="" method="POST" >
      
        <div class="modal-header">
          <button type="button" class="close" id="x" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Profile</h4>
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="modal-body">
        <label for="username">Username:</label><br>
        <p><?php echo $row['username']; ?></p>
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
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <input type="submit" id="subbtn" name ="submit" class="btn btn-primary" value="Submit">
        </div>
      </div>
    </form> 
    </div>
  </div>
    <?php } ?>
  </tbody>
</table>




</div>


<?php include 'footer.php';?>

<?php 

  } else{
    header("location: nouserfound.php");
  }

}


?>




</body>
</html>