<?php
    
    session_start();

    $userId = $_COOKIE['workoutTracker'];
    $email = $_SESSION['email'];

    if (isset($_POST["logout"])){

        setcookie("workoutTracker", "", time()- 3600, "/");
        header("Location: signup.php");

    }
    
    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");

    if (!$link) {
           
        die('Connect Error: ' . mysqli_connect_error());
    }

    
    if (isset($_COOKIE['workoutTracker']) || $_SESSION['email']){

        $query = "SELECT id, email, Name
                    FROM myusers
                    WHERE id ='".$userId."'";
                  
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['Name'];
        
        if (array_key_exists('email', $row) && $row['Name'] !== ""){
                        
            $userName = $row['Name'];
            
        } else if (array_key_exists('email', $row) && $row['Name'] === ""){
                        
            $userName = $row['email'];
            
        } 
        
    }  else {
            
        header("Location: signup.php");
            
    }
    
    $success = [];
    $alert = [];
    
    if(isset($_POST['save']) && $_POST['save'] === "save updates"){
        
        $query = "SELECT password
                    FROM myusers
                    WHERE id ='".$userId."'";
        
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        
        if (password_verify($_POST['currentPassword'], $row['password'])){
            
            if (isset($_POST['newPassword']) && $_POST['newPassword'] !== ""){
                
                if($_POST['newPassword'] === $_POST['newPasswordConfirm']){
                    
                    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
                    
                    $query = "UPDATE myusers
                              SET password = '".$newPassword."'
                              WHERE id = '".$userId."'";
                    
                    mysqli_query($link, $query);
                    
                    array_push($success, "Password Changed Successfully");
                }
                  
            }
            
            
            if(isset($_POST['newEmail']) && $_POST['newEmail'] !== "" ){

                $newEmail = mysqli_real_escape_string($link, $_POST['newEmail']);   
    
                $query = "UPDATE myusers
                            SET email = '".$newEmail."'
                            WHERE id = ".$userId;
                            
                mysqli_query($link, $query);
                            
                array_push($success, "Email Changed Successfully");    

            }
            
            if(isset($_POST['newName']) && $_POST['newName'] !== "" ){

                $newName = mysqli_real_escape_string($link, $_POST['newName']);   
    
                $query = "UPDATE myusers
                            SET Name = '".$newName."'
                            WHERE id = ".$userId;
                            
                mysqli_query($link, $query);
                            
                array_push($success, "Name Changed Successfully");    

            }
            
            
        } else {
            
            array_push($alert, 'Invalid password');
    
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
	  
<title>MY MGP - account</title>
  </head>
  <body>
    
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0 m-0">
			<div class="container col-md-8">		
		  		<a class="navbar-brand pageTitle align-middle mx-0" href="index.php"> 
					<img src="images/logo.png" class="headerLogo d-inline-block mr-2" alt="">
		  		</a>		  

		  		<div>
					<ul class="nav mx-0">
						<li class="nav-item dropleft">
							<a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="emphasis">account</span>
								<img id="avatar" src="images/avatar_mini.jpg" class="ml-2">
							</a>

							<div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
								<p class="emphasis text-center"> Logged in as: <br> <?php echo $userName ?></p>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item emphasis" href="account.php">my account</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item">
									<form method="post">
										<input type ="submit" class="dropdown-item emphasis" name="logout" value="Logout">
									</form>
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>

	<div class="row mt-4 mx-0">
		<div class="col-md-8 container p-4">
		    <div>
		        <div><?php if(array_key_exists(0, $alert)){echo "<div class='alert alert-danger'>".$alert[0]."</div>";} ?></div>
                <div><?php if(array_key_exists(0, $success)){echo "<div class='alert alert-success'>".$success[0]."</div>";} ?></div>
            </div>
            <h1> Your account </h1>
			<h4 class="pt-1"> Ensure your details are up to date! </h4>
			<form method="post">
 
				<div class="activityBlock p-4 mb-3">
					<h4 class="font-weight-bold"> Details </h4>
						
					<p class="w-75"> Name:
						<span class="font-weight-bold"> <?php echo $_SESSION['name'];?> </span>
                    	<span id="nameUpdate" class="emphasis float-right pointer"> update </span> 	
					</p>
					<input id="namePopup" type="name" class="textInput mb-3 editToggle" placeholder="enter your name" name="newEmail">        
             	
					<p class="w-75"> email:
						<span class="font-weight-bold pr-1"> <?php echo $_SESSION['email'];?></span>
                        <span id="emailUpdate" class="emphasis float-right pointer"> update </span> 
                    </p>
					<input id="emailPopup" type="email" class="textInput editToggle" placeholder="enter your email address" name="newEmail">        
				</div>
                
				<div class="activityBlock p-4 mb-3">
                    <h4 class="font-weight-bold"> Update Password </h4>
					<p> Make sure your new password is <strong>safe and memorable</strong></p>

					<label for="newPassword"> new password: </label><br>
                   	<input class ="textInput mb-3 col-lg-3" type="password" placeholder="enter new password" name="newPassword"><br>


					<label for="newPasswordConfirm"> confirm new password: </label><br>
					<input class ="textInput mb-3 col-lg-3" type="password" placeholder="re-enter new password..." name="newPasswordConfirm">	

                </div>
                
				<div class="activityBlock p-4 mb-5 bg-dark text-white clearfix">
                    <h4 class="font-weight-bold" > Update and save </h4>
					<p>For security purposes please enter your <strong> current </strong> password</p>
					
					<label for="currentPassword"> current password: </label><br>
					<input class ="textInput my-2 mr-4 col-lg-4" id="currentPassword" type="password" name="currentPassword" placeholder="enter current password">
					<input type="submit" name="save" class="button float-right mt-2 col-lg-3" value="save updates">

                </div>
            </form>
		</div>

	  
    <nav class="nav fixed-bottom navbar-expand-lg navbar-dark bg-dark p-1">
		<ul class="navbar-nav d-flex flex-row bd-highlight w-100">
			<li class="nav-item w-25 text-center py-1">
				<a href="index.php" class="nav-link emphasis d-none d-sm-inline active" id="navDash"> dashboard </a>
                <a href="index.php" class="nav-link emphasis d-inline d-sm-none" id="navDash">
                    <i class="fas fa-tachometer-alt active-sm" style="font-size: 30px;"></i>				
			    </a>
			</li>
			<li class="nav-item w-25 text-center py-1">
				<a href="stats.php" class="nav-link emphasis d-none d-sm-inline" id="navProg"> progress </a>
    	        <a href="stats.php" class="nav-link emphasis d-inline d-sm-none" id="navProg">
    	            <i class="fas fa-chart-line" style="font-size: 30px;"></i>
    	        </a>
    	    </li>
			<li class="nav-item w-25 text-center py-1">
				<a href="select_workout.php" class="nav-link emphasis d-none d-sm-inline" id="navTrain"> add a workout </a>	
	       	    <a href="select_workout.php" class="nav-link emphasis d-inline d-sm-none" id="navTrain">
	                <i class="fas fa-dumbbell" style="font-size: 30px;"></i>
	            </a>
	        </li>
			<li class="nav-item w-25 text-center py-1">
				<a href="learn.php" class="nav-link emphasis d-none d-sm-inline" id="navLearn"> learn </a>
			    <a href="learn.php" class="nav-link emphasis d-inline d-sm-none" id="navLearn">
			        <i class="fas fa-glasses" style="font-size: 30px;"></i></a>
			    </a>
			</li>
		</ul>
	</nav>
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    

    <script type="text/javascript" src="script.js"></script>
    
 
  </body>
</html>