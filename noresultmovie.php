<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'header.php';?>
</head>
<style>
 </style>
<body>

<center>
<h1 style="color:white; font-family: 'Roboto', sans-serif;">Movies</h1>
<br><br><br><br><br><br><br>
<p style="color:white; font-size:20px;">No results found</p>
</center>


<br><br><br><br><br><br><br>


<?php include 'footer.php';?>



</body>
</html>