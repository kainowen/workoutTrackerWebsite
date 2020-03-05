<?php

    session_start();
  
    include "logincheck.php";
    include "workoutreset.php";


    $submit = $_GET["submit"];
    $setOrder = 1;

   if (isset($submit) && $submit == "back"){
       
       header("Location: index.php");
              
       
   } else if (isset($submit) && $submit == "Start Session"){
       
        $planSelect = $_GET["planSelect"];
        $workoutSelect = $_GET["sessionSelect"];
        $level = strtolower(str_replace("Body", "", str_replace("Plan", "", $planSelect)));
            $level = str_replace(" ", "", $level);
        $workout = strtolower(str_replace("Body", "", $workoutSelect));
            $workout = str_replace(" ", "", $workout);
       
       if (!$link) {
           
            die('Connect Error: ' . mysqli_connect_error());
        }
       
        $query = "SELECT * FROM ".$level."_rpt_".$workout." WHERE id =".$setOrder;
       
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
       
        $_SESSION["level"] = $level;
        $_SESSION["workout"] = $workout;
        $_SESSION["targetseries"] = $row['series'].".".$row['seriesorder'];
        $_SESSION["targetExercise"] = $row['exercise'];
        $_SESSION["targetSet"] = $row['exerciseset'];
        $_SESSION["targetReps"] = $row['reps'];
        $_SESSION["targetRest"] = $row['rest'];
        $_SESSION["targetNotes"] = $row['notes'];
        $_SESSION['setOrder'] = $setOrder;
        $_SESSION['setDetails'] = [];
       
        header("Location: set_tracker.php");
        
       
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

  
    
	<title>My MGP - select workout</title>
  </head>
  <body>
	  
	 <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0 m-0">
			<div class="container col-sm-8">		
		  		<a class="navbar-brand pageTitle align-middle mx-0" href="index.php"> 
					<img src="images/logo.png" class="headerLogo d-inline-block mr-2" alt="">
		  		</a>		  

		  		<div>
					<ul class="nav mx-0">
						<li class="nav-item dropdown">
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
            <div class="container col-md-8 p-4" id="workoutSelector">
				<h1> Add a workout </h1>
				<h4> Let's get started!</h4 >

                
				<form method="$_GET">
                   <div class="activityBlock text-center">
                        <h4 class="font-weight-bold"> Select a phase </h4>
					   
					    <button id="planSelectBeginner" type="button" class="btn font-weight-bold bg-white m-3 selectButton planSelect selectButton-active"> 
							<i class="fas fa-dumbbell emphasis my-4" style="font-size: 30px;"> </i><br> 
							<span> beginner </span>
							<input class="d-none" type="checkbox" name="planSelect" value="beginner" checked>
					   </button>
					   
					    <button id="planSelectIntermediate" type="button" class="btn font-weight-bold bg-white m-3 selectButton planSelect"> 
							<i class="fas fa-dumbbell emphasis my-3" style="font-size: 50px;"></i><br>  
							<span> intermediate </span>
							<input class="d-none" type="checkbox" name="planSelect" value="intermediate">
					   </button>
					   
						<button id="planSelectaAvanced" type="button" class="btn font-weight-bold bg-white m-3 selectButton planSelect"> 
							<i class="fas fa-dumbbell emphasis my-2" style="font-size: 70px;"> </i><br>
							<span> advanced </span>
							<input class="d-none" type="checkbox" name="planSelect" value="advanced">
					   </button>
					</div> 
					
                    <div class="activityBlock text-center"> 
						<h4 class="font-weight-bold"> Select a workout </h4>						
						<button id="sessionSelectBeginner" name="sessionSelect" type="button" value="upper body 1" class="btn  font-weight-bold bg-white m-3 selectButton sessionSelect selectButton-active"> 
							<i class="fas fa-arrow-circle-up emphasis my-4" style="font-size: 50px;"> </i><br> 
							<span> upper body 1 </span>
							<input class="d-none" type="checkbox" name="sessionSelect" value="upper1" checked>
					   </button>
						
						<button id="sessionSelectIntermediate" name="sessionSelect" type="button" value="upper body 1" class="btn font-weight-bold bg-white m-3 selectButton sessionSelect"> 
							<i class="fas fa-arrow-circle-down emphasis my-4" style="font-size: 50px;"> </i><br> 
							<span> lower body </span>
							<input class="d-none" type="checkbox" name="sessionSelect" value="lower">
					   </button>

						<button id="sessionSelectAdvanced" name="sessionSelect" type="button" value="upper body 1" class="btn font-weight-bold bg-white m-3 selectButton sessionSelect"> 
							<i class="fas fa-arrow-circle-up emphasis mr-0 px-0 my-4" style="font-size: 50px;"></i>
							<i class="fas fa-arrow-circle-up emphasis ml-0 px-0 my-4" style="font-size: 50px;"></i><br> 
							<span> upper body 2 </span>
							<input class="d-none" type="checkbox" name="sessionSelect" value="upper2">
					   </button>
					</div>
                <div>
                    <input type="submit" name="submit" value="back" class="btn font-weight-bold">
                    <input type="submit" name="submit" id="start" value="Start Session" class="button px-5 mb-5 float-right">
                </div>
            </form>
		  </div>
    </div>
    <div id="bottomNav">
	  <nav class="nav fixed-bottom navbar-expand-lg navbar-dark bg-dark p-1">
				<ul class="navbar-nav d-flex flex-row bd-highlight w-100">
					<li class="nav-item w-25 text-center py-1">
						<a href="index.php" class="nav-link emphasis d-none d-sm-inline" id="navDash"> dashboard </a>
                        <a href="index.php" class="nav-link emphasis d-inline d-sm-none" id="navDash">
                            <i class="fas fa-tachometer-alt" style="font-size: 25px;"></i>				
					    </a>
					</li>
					<li class="nav-item w-25 text-center py-1">
						<a href="stats.php" class="nav-link emphasis d-none d-sm-inline" id="navProg"> progress </a>
    	        	    <a href="stats.php" class="nav-link emphasis d-inline d-sm-none" id="navProg">
    	        	        <i class="fas fa-chart-line" style="font-size: 25px;"></i>
    	        	    </a>
    	        	</li>
					<li class="nav-item w-25 text-center py-1">
						<a href="select_workout.php" class="nav-link emphasis d-none d-sm-inline active" id="navTrain"> add a workout </a>	
	            	    <a href="select_workout.php" class="nav-link emphasis d-inline d-sm-none " id="navTrain">
	            	        <i class="fas fa-dumbbell active-sm" style="font-size: 25px;"></i>
	            	    </a>
	            	</li>
					<li class="nav-item w-25 text-center py-1">
						<a href="learn.php" class="nav-link emphasis d-none d-sm-inline" id="navLearn"> learn </a>
					    <a href="learn.php" class="nav-link emphasis d-inline d-sm-none" id="navLearn">
					        <i class="fas fa-glasses" style="font-size: 25px;"></i></a>
					    </a>
					</li>
				</ul>
			</nav>
        </div>
     
        
        
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script.js"></script>
    
  </body>
</html>