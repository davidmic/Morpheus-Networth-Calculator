<?php 

require_once "connection.php";

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//     // header("location: login.php");

//     exit;
//}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/main.css">
    <title>MorphWorth</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
</head>

<body class="p-0" style="background-color: #FAFAFA">
<header class="navbar navbar-main">
        <a href="#" class="navbar-brand p-0"><img src="img/Group_no9oad.png" height="65" alt="logo"></a>
        <h5 style=" text-align: center; color: #FAFAFA; margin-top: 0; margin-left: 150px">Hello <span><?php echo htmlspecialchars($_SESSION["email"]); ?></span></h5>
        <span class="ml-auto"> <a href="logout.php"> <h5 class="d-inline">Log Out</h5></a> </span>
    </header>
    <div class="container d-flex">
        <div class="sidebar navbar-expand-md navbar-light d-inline-block">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#sidebar" style="height: 5%"> <span class="navbar-toggler-icon"> </span> </button>
            <ul class="collapse navbar-collapse" id="sidebar">
                <li id="assets" title="click to add your assets">Assets</li>
                <li id="liability"  title="click to add your liabilities">Liability</li>
                <!-- <li title="click to view results ">Net Worth</li> -->
            </ul>
        </div>
        <div class="maincontent d-inline-block">
            <div class=" hide assets" id="asset">
                <form action="" onsubmit="event.preventDefault();onAssetFormSubmit();" autocomplete="off">
                    <div class="main">
                        <h5>Add assets</h5>
                        <div class="group mt-2">
                            <label for="description]"><h2> Description</h2></label>
                            <label class="validation-error hide" id="assetDescriptionValidationError">This field is required.</label>
                            <input type="text" class="form-control" aria-describedby="nameHelp" name="assetDescription" id="assetDescription">
                        </div>

                        <div class="group mt-2">
                            <label for="description]"><h2> Quantity</h2></label>
                            <input type="number" class="form-control" aria-describedby="nameHelp" name="assetQuantity" id="assetQuantity">
                        </div>
                        <div class="group mt-1">
                            <label for="value"><h2> Value </h2></label>
                            <div class="d-flex">
                                <input type="number" class="form-control" aria-describedby="nameHelp" name="assetPrice" id="assetPrice" placeholder="value in naira">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <button type="submit" name="submit" class="submit-btn" style="margin: 3% 32%;">ADD</button>
                        </div>
                        <!-- <div class="col-md-6 text-center">
                            <button href="" onclick="popup()"  class="submit-btn" style="margin: 3% 32%;">CALCULATE</button>
                        </div> -->
                    </div>
                </form>
                <div class="table">
                    <table class="table table-border assetList" id="assetList">
                        <thead>
                            <tr>
                                <th scope="col th">Description</th>
                                <th scope="col th">Quantity</th>
                                <th scope="col th">Value &#8358;</th>
                                <th scope="col th">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr id="sample">

                                <td >demo content</td>
                                <td>demo quantity 5</td>
                                <td>demo price #30000</td>
                                <td><a href="#">Edit</a> &nbsp; <a href="#">Delete</a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="hide liability" id="liab">
                <form action="" onsubmit="event.preventDefault();onLiabilityFormSubmit();" autocomplete="off">
                    <div class="main">
                        <h5>Add liabilities</h5>
                        <div class="group mt-2">
                            <label for="description"><h2> Description</h2></label>
                            <label class="validation-error hide" id="liabilityDescriptionValidationError" style="color: #FAFAFA">This field is required.</label>
                            <input type="text" class="form-control" aria-describedby="nameHelp" name="liabilityDescription" id="liabilityDescription">
                        </div>

                        <div class="group mt-2">
                            <label for="description]"><h2> Quantity</h2></label>
                            <input type="number" class="form-control" aria-describedby="nameHelp" name="liabilityQuantity" id="liabilityQuantity">
                        </div>
                        <div class="group mt-1">
                            <label for="value"><h2> Value </h2></label>
                            <div class="d-flex">
                                <input type="number" class="form-control" aria-describedby="nameHelp" name="liabilityPrice" id="liabilityPrice" placeholder="value in naira">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <button type="submit" name="submit" class="submit-btn" style="margin: 3% 32%;">ADD</button>
                        </div>
                        <div class="col-md-6 text-center">
                            <button href="" onclick="popup()"  class="submit-btn btn-primary" id="networth" style="margin: 3% 32%;">CALCULATE</button>
                        </div>
                    </div>                </form>
                <div class="table">
                    <table class="table table-border liabilityList" id="liabilityList">
                        <thead>
                            <thead>
                                <tr>
                                    <th scope="col th">Description</th>
                                    <th scope="col th">Quantity</th>
                                    <th scope="col th">Value &#8358;</th>
                                    <th scope="col th">Actions</th>
    
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="sample2">
    
                                    <td >demo content</td>
                                    <td>demo quantity 5</td>
                                    <td>demo price #30000</td>
                                    <td><a href="#">Edit</a> &nbsp; <a href="#">Delete</a></td>
                                </tr>
    
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="hide networth mt-5" style="flex-direction: column" id="net">
                <h2 style="  text-align: center; font-weight: bolder;"> NetWorth Result </h2>
                <h5 style=" text-align: center; color: #10416B; margin-top: 0">Hello <span><?php echo htmlspecialchars($_SESSION["email"]); ?></span>, Thanks for using our service.<br>Find Your result below</h5>

                <div class="content2" style="width: 100%">
                    <!-- <h3 style="color: #10416B;text-align: center;font-weight: bolder">Assets</h3> -->
                    <!-- <div class="table d-flex" style="align-items: center; justify-content: center">
                        <table class="table table-border mt-0 assetList" id="assetResult">
                            <thead>
                                <tr>
                                    <th scope="col th"><h4 style="text-align: left">Assets</h4></th>
                                    <th scope="col th"><h4>Quantity</h4></th>
                                    <th scope="col th" > <h4> Value &#8358; </h4></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                        
                    </div>
                    <div class="table d-flex" style="align-items: center; justify-content: center">
                        <table class="table table-border mt-0 liabilityList">
                            <thead>
                                <tr>
                                    <th scope="col th"><h4 style="text-align: left">Liabilities</h4></th>
                                    <th scope="col th"><h4>Quantity</h4></th>
                                    <th scope="col th" > <h4> Value &#8358; </h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>

                        </table>
                    </div> -->
                    <div class="table d-flex" style="align-items: center; justify-content: center">
                         <table class="table table-border mt-0">
                            <thead>
                                <tr>
                                    <th scope="col th"><h4 style="text-align: left">Total Asset &#8358;</h4></th>
                                    <th scope="col th"><h4>Total Liability &#8358;</h4></th>
                                    <th scope="col th" > <h4>NetWorth &#8358;</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="test1"></td>
                                    <td id="test2"></td>
                                    <td id="test3"></td>
                                </tr>
                            </tbody>

                        </table>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <a href="" onclick="window.print()">Click here to print</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/asset.js"></script>
    <script src="js/liability.js"></script>
    <script src="js/result.js"></script>
    <script src="js/show.js"></script>
<script>
    </script>
</body>

</html>