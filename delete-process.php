<?php
//REMOVE FROM CART
include "config.php";
if(isset($_REQUEST['code']) && $_REQUEST['code']=='removeItem'){

    $temp_id = mysqli_real_escape_string($link, $_REQUEST['id']);
    $sql = "DELETE FROM users WHERE id='$temp_id'";
    if (mysqli_query($link, $sql)) {
    header("location: adminuserlist.php");
    } else {
        
    }
}

if(isset($_REQUEST['code']) && $_REQUEST['code']=='removeMovie'){

    $temp_movieid = mysqli_real_escape_string($link, $_REQUEST['movieid']);
    $sql = "DELETE FROM movie WHERE movieid='$temp_movieid'";
    if (mysqli_query($link, $sql)) {
    header("location: addmovie.php");
    } else {
        
    }
}

if(isset($_REQUEST['code']) && $_REQUEST['code']=='removeTvshow'){

    $temp_tvshowid = mysqli_real_escape_string($link, $_REQUEST['tvshowid']);
    $sql = "DELETE FROM tvshow WHERE tvshowid='$temp_tvshowid'";
    if (mysqli_query($link, $sql)) {
    header("location: addtvshow.php");
    } else {
        
    }
}

if(isset($_REQUEST['code']) && $_REQUEST['code'] == 'removeReviewtxt')
{
    $id = $_GET['id']; 
    
  $sql = "DELETE FROM moviereview WHERE id = '$id' ";
    
  if (mysqli_query($link, $sql)) {

    header("location: myreview.php");
  } else {
  }
}

if(isset($_REQUEST['code']) && $_REQUEST['code'] == 'removeReviewtxtfortv')
{
    $id = $_GET['id']; 
    
  $sql = "DELETE FROM tvshowreview WHERE id = '$id' ";
    
  if (mysqli_query($link, $sql)) {

    header("location: mytvreview.php");
  } else {
  }
}
?>





