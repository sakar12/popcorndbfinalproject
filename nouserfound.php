<?php
// Initialize the session
session_start();
 
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

<center>
<h1 style="color:white; font-family: 'Roboto', sans-serif;">List of Users</h1>
<br><br><br><br><br><br><br>
<p style="color:white; font-size:20px;">No users found</p>
</center>


<br><br><br><br><br><br><br>

<?php include 'footer.php';?>



</body>
</html>