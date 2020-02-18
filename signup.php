<?php

    session_start();

    $email = $_POST["email"];
    $password = $_POST["password"];
    $cookies = $_POST["cookies"];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $_SESSION["email"] = $email;
    $errors=[];
    
       

    if(array_key_exists("email", $_POST) or array_key_exists("password", $_POST)){
        
        if (isset($cookies)){
            
            setcookie("workoutTracker", $email, time() + (60 * 60 * 24), "/");
            
                            
        } 
        
        if($email == ""){
            
            array_push($errors, "please enter a valid email address");
            
        } else if ($password === ""){
            
            array_push($errors, "Please enter a password");
            
        } else {
            
            $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
       
            
            if (mysqli_connect_error()){
                die ("There was an error connecting to the database");
            }
            
            if (isset($_POST["signUp"])){
            $query = "SELECT id FROM myusers WHERE email = '".mysqli_real_escape_string($link, $email)."'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);
                
                if ($row > 1){
                    
                        array_push($errors,  "The email address ".$email." is already in use.");
                        
                    
                    } else {
                    
                        //header("Location: index.php");
                    
                        $query = "INSERT INTO myusers(email, password) 
                        VALUES('".mysqli_real_escape_string($link, $email)."', '".mysqli_real_escape_string($link, $hash)."')";
                        
                        $result = mysqli_query($link, $query);
                        
                        $query = "SELECT id
                                FROM myusers 
                                WHERE email = '".$email."'";
                        
                        $result = mysqli_query($link, $query);
                        $row = mysqli_fetch_array($result);
                        $idHolder = $row['id'];
                        $exerciserecord = $idHolder."exerciserecord";
                        
                        echo $exerciserecord;
                        
                        $query = "CREATE TABLE ".$exerciserecord."(
                            id int NOT NULL AUTO_INCREMENT,
                            PRIMARY KEY (id)
                            )";
                        
                        mysqli_query($link, $query);
                        
                    }
        
                } else if (isset($_POST["logIn"])){ 
                    
                    $query = "SELECT password FROM myusers WHERE email ='".mysqli_real_escape_string($link, $email)."'";
                    $result = mysqli_query($link, $query);
                    $row = mysqli_fetch_array($result);
            
                    if($row["password"] == ""){
                        
                        array_push($errors, "This username does not exist");
                        
                    } else if ($verify = password_verify($password, $row["password"])){
                    
                       header("Location: index.php");
                       
                    } else {
                        
                        array_push($errors, "Email and password do not match <br>");

                    }
                    
                    
                }
        
            }
            
        }
    
?>

<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed:500|Noto+Sans:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        
body{
            
            font-family: 'Noto Sans', sans-serif;
            padding: 0;
            margin: 0;
            
        }
        
        h1, h2, h3, h4 {

            font-family: 'Fira Sans Extra Condensed', sans-serif;

        }
        
        .headBanner{
            
            color: white;
            background-color: #4EA5ED;
            padding-left: 30px;
            margin-right: 0;
        }
        
        #avatar{
            
            width: 40px;
            height: 40px;
            border-radius: 50%;
            position: relative;
 
 
        }

        .navBTN{
            
            position: absolute;
            right: 11px;
            padding: 0;
            margin: 0;
        }
        
        #dropdown{
            
            margin-top: 15px;
            background-color: #4EA5ED;
            border: none;
            padding: 0;
        }
        
        .dropdown-item{
            
            font-weight: bold;
            color: white;
            border-bottom: solid 1px #99B5C9;
            
        }
        
        .subHeader{
            
            padding-left: 15px;
            
        }
        
        #activityFeed{
            
            height: 520px;
            overflow-y: scroll;
            
        }
        
        .activityBlock{
        
            border: solid 1px gray;
            margin-bottom: 5px;
            padding-left: 5px;
            clear: both;
    
        }
    
        .activityBanner {
            
            font-family: 'Fira Sans Extra Condensed', sans-serif;
            background-color:#317AAE ;
            color: white;
            margin-left: -5px;
            padding-left: 5px;
        }
        
        
        .activityDate{
            
            background-color:#99B5C9 ;
            color: white;
            margin-left: -5px;
            margin-bottom: 0;
            padding-left: 5px;
            height: 20px;
            font-size: 10px;
            
        }
        
        .nav-link{
            
            width: 50%;
            height: 60px;
            color: white;
            background-color: #4EA5ED;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            position: relative;
            
        }
        
        .nav-link:hover{
            
            color: white;
            filter: brightness(80%);
            
        }
        
        
        #navTrain{
            
            width: 80px;
            height: 80px;
            position: absolute;
            left: 50%;
            top: -20px;
            padding-top: 16px;
            margin-left: -40px;
            background-color: black;
            border: solid 10px white;
            border-radius: 50%;
            z-index: 1;
            
        }
        
        .logInElements{
            
            display: none;
            
        }
        
        .btn-next{
            
            background-color: #4EA5ED;
            color: white;
            font-weight: bold;
            width: 150px;
        }
        
        .btn-next:hover{
            
            color: white;
            filter: brightness(80%);
            
        }
        
        .btn-back{
            
            background-color: black;
            color: white;
            font-weight: bold;
            width: 150px;
        }
        
        .btn-black:hover{
            
            color: white;
            filter: brightness(80%);
            
        }
        
        .margin-top{
            
            margin-top:20px;
            
        }
        
        .logSignBox{
            
            width: 400px;
            
        }
        
        .Jumbotron{
            
            width: 100%;
            height: 530px;
            position: relative;
            background: url("images/lift2.jpg");
            background-size: cover;
            background-position: center;
            overflow: hidden;
            color: white;
            
        }
        
        .margin-negate{
            
         margin-top: -20px;   
            
        }
        
         .imageFilter{
    
            position: relative;
            width: 106%;
            height: 111%;
            background-color: black;
            opacity: 0.6;
            margin: -10px;
    
        }
        
        .signUpElements, .logInElements, .errors{
            
            float: left;
            position: relative;
            z-index: 1;
        }
        
        .centered{
            
            text-align: center;
            
        }
        
    </style>

    
    <title>My Muscle Gain Plan</title>
  </head>
  <body>
    
    <div class="headBanner">
        <h1>My Workout Tracker </h1><br>
        <p> Find Workout Plans To Help You Reach Your Goals</p>
    </div>
    <div class="Jumbotron margin-negate centered">
        <div class="container logSignBox">
            <div class="margin-top errors">
                <?php
                    
                    foreach($errors as $key => $value){
                        echo '<div class="alert alert-danger"><strong>'.$value.'</strong></div>';
                    }
                        
                ?>
                
            </div>
                
            <p class="signUpElements margin-top">Interested? Sign-up now.</p>
            <p class="logInElements margin-top">Sign-in using your username and password.</p>
            
            <form method='post'>
                <div class="form-group signUpElements" >
                    <input type="email" class="form-control margin-top" id="signUpInputEmail" aria-describedby="emailHelp" placeholder="Your email" name="email">
                    
                    <input type="password" class="form-control margin-top" id="signUpInputPassword1" placeholder="Your password" name="password">
                    
                    <label for"signUpCookies" class="margin-top"><strong> Stay Logged in? </strong></label>
                        <input type="checkbox" id="signUpCookies" value="yes" name="cookies[]" checked> 
                    <br>
                    <input type="submit" class="btn btn-next" value ="Sign Up" name="signUp">
                </div>
            </form>
        	
        	
    	    <form method='post'>
                <div class="form-group logInElements">
                    <input type="email" class="form-control margin-top" id="logInInputEmail" aria-describedby="emailHelp" placeholder="Your email" name="email">
                    
                    <input type="password" class="form-control margin-top" id="logInInputPassword" placeholder="Your password" name="password">
                        
                    <label for"logInCookies" class="margin-top"><strong>Stay Logged in? </strong></label>
                        <input type="checkbox" id="logInCookies" value="yes" name="cookies[]" checked>
                    <br>
                    <input type="submit" class="btn btn-next" value ="Log In" name="logIn">
                </div>
            </form>
        	<br>
        	<a href="#" class="signUpElements logSignSwitch" id="logInSelect"> Already signed-up? Log In </a>
        	<a href="#" class="logInElements logSignSwitch" id="signUpSelect"> Don't have an account? Sign-Up </a>
        </div>  
        <div class="imageFilter"></div>
    </div>
    
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
        
        $(".logSignSwitch").click(function(){
            
            $(".logInElements").toggle();
            $(".signUpElements").toggle();
            
        });
        
    </script>
 
  </body>
</html>