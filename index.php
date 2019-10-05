<?php
session_start();
require_once "vendor/facebook/graph-sdk/src/Facebook/autoload.php";
require_once "includes/connection.php";
require_once "includes/settings.php";
 
// Define variables and initialize with empty values
$name= $email= $password= $confirm_password= "";
$name_err= $email_err= $password_err= $confirm_password_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
     //Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter Your full name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT UserID FROM morph WHERE FullName = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $name_err = "This Name is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT UserID FROM morph WHERE Email = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    $password = trim($_POST["password"]);
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must be at least 8 characters.";
    } elseif(!preg_match("#[0-9]+#", $password)) {
        $password_err = "Your Password Must Contain At Least 1 Number!";
    }elseif(!preg_match("#[A-Z]+#", $password)) {
        $password_err = "Your Password Must Contain At Least 1 Capital Letter!";
    }elseif(!preg_match("#[a-z]+#", $password)) {
        $password_err = "Your Password Must Contain At Least 1 Lowercase Letter!";
    }else{
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
    
    // Check input errors before inserting in database
    if(empty($name_err)&&empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO morph (FullName, Email, Password) VALUES (?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss",$param_name, $param_email, $param_password);
            
            // Set parameters
            $param_name= $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: https://morphnetworth.000webhostapp.com/login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}	
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <header class="navbar p-0">
        <a href="#" class="navbar-brand p-0"><img src="https://res.cloudinary.com/anikefisher/image/upload/v1569282034/Group_no9oac.png" height="65" alt="logo"></a>
    </header>
    <div style="margin-top:1%" class="container">
        <div class="row body-form">
            <div class="col-md-6 half">
                <h1>Find out how much you are worth today</h1>
                <h2>Calculating your networth just got easier with MorphWorth</h2>
            </div>
            <div class="col-md-6 form">
                <a class="login" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>"><img alt="googlelogin" src="img/sign-in-with-google.png" width="150px" sizes="100px"></a>
                <h3 class="body-text"> Sign Up! </h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-center">
                        <form>
                            <div class="form-group  <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                <label for="name">Full name</label>
                                <input type="name" name="name" class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="First and Last Name" value="<?php echo $name; ?>">
                                <span class="help-block text-danger"><?php echo $name_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="xyz@email.com"  value="<?php echo $email; ?>">
                                <span class="help-block text-danger"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="******" value="<?php echo $password; ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                <span class="help-block text-danger"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                <label for="password">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="******" value="<?php echo $confirm_password; ?>">
                                <span class="help-block text-danger"><?php echo $confirm_password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="submit-btn">Sign Up</button>
                                 <?php 
                            
                            $fb = new Facebook\Facebook([
                                'app_id' => '391266395158248', // Replace {app-id} with your app id
                                'app_secret' => 'a0d9d8e4d59da425540c9cecd067d762',
                                'default_graph_version' => 'v3.2',
                                ]);
                              
                              $helper = $fb->getRedirectLoginHelper();
                              
                              $permissions = 'Facebook User'; // Optional permissions
                              $_SESSION['email'] = $permissions;
                              
                              $loginUrl = $helper->getLoginUrl('https://morphnetworth.000webhostapp.com/fb-callback.php');
                              
                              echo '<a href="' . htmlspecialchars($loginUrl) . '">    or Log in with Facebook!</a>';
                            ?>
                            </div>
                            <h6 class=""> Already have an account? <a href="login.php"> Log In </a> </h6>
                             
                        </form>
                    </div>
                </form>
               
            </div>
        </div>
    </div>

</body>

</html>
