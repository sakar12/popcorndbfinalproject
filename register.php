<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $firstname = $lastname = $phone = $email = $confirm_password = $target_file ="";
$username_err = $password_err = $firstname_err = $lastname_err = $phone_err = $email_err = $confirm_password_err = $target_file_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
            
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 5){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a firstname.";  
    } elseif(strlen(trim($_POST["firstname"])) < 1){
        $firstname_err = "Firstname must have atleast 1 character.";   
    } else{
        $firstname = trim($_POST["firstname"]);
    }

    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter a lastname.";  
    } elseif(strlen(trim($_POST["lastname"])) < 1){
        $lastname_err = "Lastname must have atleast 1 character.";   
    } else{
        $lastname = trim($_POST["lastname"]);
    }

    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter a Phone Number";  
    } elseif(strlen(trim($_POST["phone"])) < 10){
        $phone_err = "Phone number must have 10 digits";   
    } else{
        $phone = trim($_POST["phone"]);
    }

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a valid email";  
    } elseif(strlen(trim($_POST["phone"])) < 1){
        $email_err = "Email must have atleast 1 character.";   
    } else{
        $email = trim($_POST["email"]);
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($firstname_err) && empty($lastname_err) && empty($phone_err) && empty($email_err) && empty($confirm_password_err) && empty($target_file_err)){
        
        // // Prepare an insert statement
        // $sql = "INSERT INTO users (username, password,firstname,lastname,phone,email,img) VALUES (, ? ,?, ?, ?, ?,?)";

        
        // if($stmt = mysqli_prepare($link, $sql)){
           
        //     // Bind variables to the prepared statement as parameters
            // mysqli_stmt_bind_param($stmt, "ssssisb", $param_username, $param_password,$param_firstname,$param_lastname,$param_phone,$param_email,$param_target_file);
            
        //     // Set parameters
            $target_dir = "img";
             $target_file = basename($_FILES["image"]["name"]);
            $param_username = $username;
             $param_firstname = $firstname;
            $param_lastname = $lastname;
             $param_phone = $phone;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_target_file = $target_file;
            
            
            
            $sql = "INSERT INTO users (username, password, firstname, lastname, phone, email , img) VALUES ('$username', '$param_password' ,'$firstname', '$lastname', '$phone', '$email','$target_file')";

            // $res = mysqli_query($link,$sql);


        //     // Attempt to execute the prepared statement
       
        // if(mysqli_stmt_execute($stmt)){
            if(mysqli_query($link,$sql)){
            move_uploaded_file($_FILES["image"]["tmp_name"], "$target_dir/$target_file");
            
        
        }
        header("location: index.php");
        //     // Close statement
            mysqli_stmt_close($stmt);
        //  }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
       body {
           font-family: Arial, Helvetica, sans-serif;
           color:white;
           background-image: linear-gradient( rgba(0, 0, 0, 0.81), rgba(0, 0, 0, 0.9) ), url("./img/logincover.jpg");
           }

        form {
            
            text-align: center;
            }

input[type=text], input[type=password], input[type=number], input[type=email]{
  width: 50%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
  -moz-appearance: textfield;
}

input[type=file]{
  width: 50%;
  padding: 12px 20px -10px 0px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
  -moz-appearance: textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  filter: brightness(90%);
  width: 20%;
}

.wrapper{
    width:60%;
}

#registerbtn{
    border:none;
    border-radius: 12px;
    width:15%;
    margin-left:10px;
    background-color:#007321;
    transition: 0.3s;
    padding: 15px;
}

#registerbtn:hover{
    background-color:#149c3b;
}

@media only screen and (min-width:300px) and (max-width:1200px) {
    #registerbtn{
    width:30%;
    padding:8px 15px;
}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }

  form {
        width:20%;
     }

}
</style>
</head>

<center>
<body>
    <div class="wrapper">
        <br><br>
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

        <div class="imgcontainer">
            <br>
            <img src="./img/avatar3.png" class="avatar">
            </div>
            <br>
            
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Username" type="text" name="username" class="form-control" required value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <input placeholder="First Name" type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Last Name" type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($phone)) ? 'has-error' : ''; ?>">
                <input placeholder="Phone Number" type="number" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email)) ? 'has-error' : ''; ?>">
                <input placeholder="Email" type="email" name="email" class="form-control" required value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Enter Password" type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Confirm Password" type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
            
            <input type="file" name="image" class="form-control">
            </div>
            
            
            <div class="form-group">
                <input type="submit" name ="save" class="btn btn-primary" value="Submit" id="registerbtn">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
        </form>
    </div>   
    <br><br><br><br>
</body>
</center>

</html>