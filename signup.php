<?php

    session_start();

    $email = $_POST["email"];
    $password = $_POST["password"];
    $cookies = $_POST["cookies"];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $_SESSION["email"] = $email;
    $errors=[];

    if (isset($_COOKIE['workoutTracker'])){
        
        header("Location: index.php");
        
    }


        if($email === ""){
            
            array_push($errors, "please enter a valid email address");
            
        } else if ($password === ""){
            
            array_push($errors, "Please enter a password");
            
        } else {
            
            $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
       
            
            if (mysqli_connect_error()){
                
                die ("There was an error connecting to the database");
            
            }
            
            if (isset($_POST['signUp'])){

                $query = "SELECT id 
                            FROM myusers 
                            WHERE email = '".mysqli_real_escape_string($link, $email)."'";

                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
                
                if ($row > 1){
                    
                    array_push($errors,  "The email address ".$email." is already in use.");
                        
                    
                } else {
                    
                    header("Location: index.php");

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
         
                    $date = date('Y-m-d H:i:s', time());
             
                    $query = "INSERT INTO notificationrecord(userid, notificationid, date_created) 
                              VALUES(".$idHolder.", 1, '".$date."')";
                  

                    $result = mysqli_query($link, $query);

                    $query = "CREATE TABLE ".$exerciserecord."(
                              id int NOT NULL AUTO_INCREMENT,
                              PRIMARY KEY (id)
                              )";
                        
                    mysqli_query($link, $query);

                    if (isset($cookies)){
                        
                        setcookie("workoutTracker", $idHolder, time() + (60 * 60 * 24), "/");
                   
                    }
                    
                    
                    
                }
        
            } else if (isset($_POST["logIn"])){ 
                    
                    $query = "SELECT * 
                                FROM myusers 
                                WHERE email ='".mysqli_real_escape_string($link, $email)."'";
                    
                    $result = mysqli_query($link, $query);
                    $row = mysqli_fetch_array($result);
            
                    if($row["email"] == ""){
                        
                        array_push($errors, "This username does not exist");
                        
                    } else if ($verify = password_verify($password, $row["password"])){
                
                        header("Location: index.php");
                       
                        $query = "SELECT id
                                  FROM myusers 
                                  WHERE email = '".$email."'";
                        
                        $result = mysqli_query($link, $query);
                        $row = mysqli_fetch_array($result);
                        
                        $idHolder = $row['id'];
                       
                       
                        if (isset($cookies)){

                            setcookie("workoutTracker", $idHolder, time() + (60 * 60 * 24), "/");
                
                        }
                       
                } else {
                        
                    array_push($errors, "Email and password do not match <br>");

                }
                    
                    
            }
        
        }

?>

<!doctype html>
<html lang="en">
  	<head>

    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    
	  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    	<link rel="stylesheet" href="style.css">

    
    	<title>My Muscle Gain Plan</title>
  	</head>
 	<body>
	<div id="background" class="m-0">
		<div id="signUpBody" class="container">
			<img id="logo" src="images/logo.png" class="p-4">
				<h1>My Workout Tracker </h1>
				<p> Register today to find a workout plan that's 
				<span class="emphasis"> right for you </span> to reach <span class="emphasis"> your full potential</span></p>
	

				<div class="logSignBox">
					<div class="errors">  
						<div> 
						    <p>
						        <?php
                    
                                    foreach($errors as $key => $value){
                                        echo '<div class="alert alert-danger"><strong>'.$value.'</strong></div>';
                                        
                                    }
                        
                                ?>
						    </p>
						</div>
					</div>

					<form method='post'>
						<div class="form-group signUpElements" >
							<div class="inputShell ">
								<label for="signUpInputEmail" >email address:</label>
								<input type="email" class="textInput col-sm" id="signUpInputEmail" aria-describedby="emailHelp" placeholder="name@example.com" name="email">
							</div>

							<div class="inputShell">
								<label for="signUpInputPassword1"> password:</label>
								<input type="password" class="textInput col-sm" id="signUpInputPassword1" placeholder="enter a password..." name="password">
							</div>

								<label for="signUpCookies" class=""><strong> Stay Logged in? </strong></label>
								<input type="checkbox" id="signUpCookies" value="yes" name="cookies[]" checked> 
							<br>
							<input type="submit" class="button px-5" value ="Sign Up" name="signUp">
						</div>
					</form>





					<form method='post'>
						<div class="form-group logInElements">
							<div class="inputShell">
								<label for="logInInputEmail" >email address:</label>
								<input type="email" class="textInput col-sm" id="logInInputEmail" aria-describedby="emailHelp" placeholder="name@example.com" name="email">
							</div>

							<div class="inputShell">
								<label for="logInInputPassword"> password:</label>
								<input type="password" class="textInput col-sm" id="logInInputPassword" placeholder="enter a password..." name="password">
							</div>

								<label for="logInCookies"><strong> Stay Logged in? </strong></label>
								<input type="checkbox" id="logInCookies" value="yes" name="cookies[]" checked> 
							<br>
							<input type="submit" class="button px-5" value ="Log In" name="logIn">
						</div>
					</form>



					<p class="signUpElements pb-5 mb-0"> Already have an account?<a href="#" class="emphasis signUpElements logSignSwitch" id="logInSelect"> Log-In </a></p>
					<p class="logInElements pb-5 mb-0"> Don't have an account?<a href="#" class="emphasis logInElements logSignSwitch" id="signUpSelect"> Sign-Up </a></p>

			  </div>  
	  	</div>
	</div>	  
		  <div id="footer" class="align-middle"> 
			  <p class="py-2  m-0">designed + built by 
				  <span class="emphasis">liam kain owen</span>
			  </p>
		  </div>
		  
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script.js"></script>
 
  </body>
</html>