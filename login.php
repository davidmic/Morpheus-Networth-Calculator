<?php
session_start();
require_once "vendor/facebook/graph-sdk/src/Facebook/autoload.php";
require_once "connection.php";

/*declaring variables*/

$email = $password = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT UserID, email, password FROM morph WHERE email = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if email exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($UserID, $email, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["UserID"] = $UserID;
                            $_SESSION["email"] = $email;
                            ?>
                            <script>
                            window.location="main.php";
                            </script>
                            <?php
                            // Redirect user to welcome page
                            // header("location: main.php");
                       // echo ("Welcome to MorphWorth!");
                   
                    }else{
                    
                    
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Log In</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <header class="navbar p-0">
        <a href="#" class="navbar-brand p-0"><img src="https://res.cloudinary.com/anikefisher/image/upload/v1569282034/Group_no9oac.png" alt="logo"></a>
    </header>
    <div style="margin-top:1%" class="container">
        <div class="body-form">
            <h3 class="mb-4"> Login </h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-center">
                    <form>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email Address" value="<?php echo $email; ?>">
                            <span class="help-block text-danger"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group  <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="******">
                            <span class="help-block text-danger"><?php echo $password_err; ?></span>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="submit-btn" value="Login">Log In</button>
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
                              echo '<br><br>';
                              echo '<a href="' . htmlspecialchars($loginUrl) . '">    or Log in with Facebook!</a>';
                            ?>
                        </div>
                        <h6 class=""> Not registered yet? <a href="index.php"> Sign Up </a> </h6>
                    </form>
                </div>
            </form>
        </div>

    </div>

</body>

</html>
