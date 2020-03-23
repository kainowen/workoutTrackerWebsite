<?php

    session_start();

    $email = $_POST["email"];
    $password = $_POST["password"];
    $cookies = $_POST["cookies"];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $_SESSION["email"] = $email;
    $emailErrors=[];
    $passwordErrors=[];
    
    if (isset($_COOKIE['workoutTracker'])){
        
        header("Location: index.php");
        
    }


        if($email === ""){
            
            array_push($emailErrors, "please enter a valid email address");
            
        } else if ($password === ""){
            
            array_push($passwordErrors, "Please enter a password");
            
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
                    
                    array_push($emailErrors,  "This email address is already in use.");
                        
                    
                } else {
                    
                    header("Location: index.php");

                    $query = "INSERT INTO myusers(email, password, key_lift_1, key_lift_2, key_lift_3, key_lift_4, key_lift_5) 
                            VALUES('".mysqli_real_escape_string($link, $email)."', '".mysqli_real_escape_string($link, $hash)."', 102, 46, 82, 115, 21)";
                        
                    $result = mysqli_query($link, $query);

                    $query = "SELECT id
                            FROM myusers 
                            WHERE email = '".$email."'";
                        
                    $result = mysqli_query($link, $query);
                    $row = mysqli_fetch_array($result);

                    $idHolder = $row['id'];
                    $exerciserecord = $idHolder."exerciserecord";
                    $workoutDiary = $idHolder."workoutdiary";
         
                    $date = date('Y-m-d H:i:s', time());
             
                    $query = "INSERT INTO notificationrecord(userid, notificationid, date_created) 
                              VALUES(".$idHolder.", 1, '".$date."')";
                  

                    $result = mysqli_query($link, $query);

                    $query = "CREATE TABLE ".$exerciserecord."(
                              id int NOT NULL AUTO_INCREMENT,
                              PRIMARY KEY (id)
                              )";
                        
                    mysqli_query($link, $query);

                    $query = "CREATE TABLE ".$workoutDiary."(
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
                        
                        array_push($emailErrors, "this account doesn't exist");
                        
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
                        
                    array_push($passwordErrors, "these details don't match <br>");

                }
                    
                    
            }
        
        }

?>

<!doctype html>
<html lang="en">
  	<head>

    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://kit.fontawesome.com/83a74e8223.js" crossorigin="anonymous"></script>
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    	<link rel="stylesheet" href="style.css">
        <style>
        

    
        </style>
    
    	<title>My Muscle Gain Plan</title>
  	</head>
 	<body>
	<div id="background" class="min-vh-100">
		<div id="signUpBody" class="container">
			<img id="logo" src="images/logo.png" class="p-4">
				<h1>My Workout Tracker </h1>
				<p> Register today to find a workout plan that's 
				<span class="emphasis"> right for you </span> to reach <span class="emphasis"> your full potential</span></p>
	
 
				<div class="logSignBox">
					<form method='post'>
						<div class="form-group signUpElements">
							<div class="inputShell mb-3">
								<label for="signUpInputEmail" class="input-label">email address:</label><br>
								<input type="email" class="textInput w-100" id="signUpInputEmail" aria-describedby="emailHelp" placeholder="name@example.com" name="email">
            						<?php
                                            
                                        foreach($emailErrors as $key => $value){
                                                 
                                            echo '<div class="alerts"><i class="fas fa-exclamation-circle"></i>'.$value.'</div>';
                                                
                                        }
                                    ?>
							</div>

							<div class="inputShell mb-3">
								<label for="signUpInputPassword1" class="input-label"> password:</label><br>
								<input type="password" class="textInput w-100" id="signUpInputPassword1" placeholder="enter a password..." name="password">
            						<?php
                                            
                                        foreach($passwordErrors as $key => $value){
                                                 
                                            echo '<div class="alerts"><i class="fas fa-exclamation-circle"></i>'.$value.'</div>';
                                                
                                        }
                                    ?>
							</div>

								<label for="signUpCookies" class=""><strong> Stay Logged in? </strong></label>
								<input type="checkbox" id="signUpCookies" value="yes" name="cookies[]" checked> 
							<br>
							<input type="submit" class="button px-5" value ="Sign Up" name="signUp">
						</div>
					</form>





					<form method='post'>
						<div class="form-group logInElements">
							<div class="inputShell mb-3">
								<label for="logInInputEmail" class="input-label">email address:</label><br>
								<input type="email" class="textInput w-100" id="logInInputEmail" aria-describedby="emailHelp" placeholder="name@example.com" name="email">
            						<?php
                                            
                                        foreach($emailErrors as $key => $value){
                                                 
                                            echo '<div class="alerts"><i class="fas fa-exclamation-circle"></i>'.$value.'</div>';
                                            
                                        }
                                    ?>
							</div>

							<div class="inputShell mb-3">
								<label for="logInInputPassword" class="input-label">password:</label><br>
								<input type="password" class="textInput w-100" id="logInInputPassword" placeholder="enter a password..." name="password">
            						<?php
                                            
                                        foreach($passwordErrors as $key => $value){
                                                 
                                            echo '<div class="alerts"><i class="fas fa-exclamation-circle"></i>'.$value.'</div>';
                                                
                                        }
                                    ?>
							</div>

								<label for="logInCookies" class=""><strong> Stay Logged in? </strong></label>
								<input type="checkbox" id="logInCookies" value="yes" name="cookies[]" checked> 
							<br>
							<input type="submit" class="button px-5" value ="Log In" name="logIn">
						</div>
					</form>



					<p class="signUpElements mb-0 pb-5"> Already have an account?<a href="#" class="emphasis signUpElements logSignSwitch" id="logInSelect"> Log-in here</a></p>
					<p class="logInElements mb-0 pb-5"> Don't have an account?<a href="#" class="emphasis logInElements logSignSwitch" id="signUpSelect"> Sign-up here </a></p>

			  </div>  
	  	</div>
	</div> 
	
        <div id="cookieConsent">
            <div class="container clearfix">
                <h6> Cookie Consent</h6>
                <p class="float-left"> This website uses cookies to keep you logged in. To opt out of this service uncheck the "stay logged in?" checkbox</p>
                <button class="button col-sm-2 float-right mb-2" id="cookieButton"> Ok </button>
            </div>
        </div>
	
	
	
		<footer id="footer" class="align-middle"> 
			<p class="py-2 m-0">designed + built by 
				<span class="emphasis">liam kain owen</span>
			</p>
		</footer>
		  
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/script.js"></script>
    <script>
        
        $("#cookieButton").click(function(){
            
            $("#cookieConsent").hide();
            
        })
        
    </script>
  </body>
</html>