<?php
    session_start();

        include "./php_functions/logincheck.php";
        include "./php_functions/workout_populate.php";

        if (($_SESSION['level'] === '') ){
            header("location: select_workout.php");
        }   

        $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
       
        if (!$link) {
            die('Connect Error: ' . mysqli_connect_error());
        }
       
        $query ="SELECT weight, reps, rpe
                FROM ".$exerciseRecord."
                WHERE exerciseid = '".$exerciseId."'
                ORDER BY id DESC
                LIMIT 5";
               
        $result = mysqli_query($link, $query);
        
        $liftHistory = [];
        $record = "<strong>Lift History: </strong><br>";
                
        $i = 0;
                
        foreach ($result as $value){
            array_push($liftHistory, $value);
            if ($i == 0){
                $record .= "<strong>Weight: ".$liftHistory[$i]['weight']." X Reps: ".$liftHistory[$i]['reps']." @ RPE: ".$liftHistory[$i]['rpe']."</strong><br>";
            } else {
                $record .= "Weight: ".$liftHistory[$i]['weight']." X Reps: ".$liftHistory[$i]['reps']." @ RPE: ".$liftHistory[$i]['rpe']."<br>";
            }
            $i++;
        };
        
        if ($_GET["weightUsed"] != "" && $_GET["repsComplete"] !=""){
            
            if ($_GET["submit"] == "next set"){
                
                $setOrder++;
                
                $rpeDetails = explode(":", $_GET['rpeLevel']);
           
                $setDetails1=[];
                array_push($setDetails1, $_GET["weightUsed"], $_GET["repsComplete"], $rpeDetails[0]);

                $setDetails2 = serialize($setDetails1);
                array_push($_SESSION['setDetails'], $setDetails2);

                workoutPopulate($setOrder, $level, $workout, $link);

            }
        
        } else if ($_GET["submit"] == "back"){

            if ($setOrder > 1){
                
                $setOrder--;
                
                workoutPopulate($setOrder, $level, $workout, $link);
                
            } else {
                
                header("Location: select_workout.php");
                
            }
        
        }
        
        $exercise = $_SESSION["targetExercise"];
        $exerciseId = $_SESSION["exerciseId"];
        $series = $_SESSION["targetseries"];
        $set = $_SESSION["targetSet"];
        $reps = $_SESSION["targetReps"];
        $rest = $_SESSION["targetRest"];
        $notes = $_SESSION["targetNotes"];    

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
	  <title>My MGP - Set Tracker</title>
  </head>
  <body>
	  
	  <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0 m-0">
			<div class="container col-md-8">		
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
								<p class="dropdown-item emphasis"> Logged in as: <br> <?php echo $userName ?></p>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item emphasis" href="account.php">my account</a>
								<div class="dropdown-divider"></div>
								<a>
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
	  
	  	<div class="row my-3 mx-0">
			<div class="col-md-8 container p-4">
        		<h1 id="set"> <?php echo "Set: ".$set ?> </h1>
				<h4 class="pt-1">Workout: <strong> <?php echo $level.", ".$workout;?></strong></h4>
	  			<h4 class="pt-1 d-inline">Exercise: <strong> <?php echo $series." ".$exercise ?> </strong></h4>
	  			    <p id="popover" class="d-inline align-bottom" data-container="body" data-html="true" data-toggle="popover" data-placement="bottom" data-content='<?php echo $record ?>' > <i class="fas fa-info-circle emphasis pointer"> </i></p>
				
				<div class="activityBlock bg-dark text-white mt-3 clearfix timer">
					<div class="float-left">
						<h5><strong> Timed break</strong></h5>
						<p> Before you start again we advice taking a timed break</p>
						<input class="d-none"type="checkbox" value="<?php echo $rest ?>" id="rest">
					</div>
					<h2 id="restTimer" class="emphasis float-lg-right float-left m-2 mt-0">start</h2>
					<audio id="beep">
    		        	<source src="sounds/beep-07.mp3" type="audio/mpeg">
    		    	</audio>
				</div>
				
				
				
				<form method="get">
					<div class="activityBlock">
						
						<div class="row">
							
							<div class="col-lg-4 px-2 inputShell">
        		    			<?php echo $weightPlaceholder ?>		 
							    <?php 
        		        
                    		        if(isset($_GET["submit"]) && $_GET["submit"] == "next set" && $_GET["weightUsed"] ==""){
                                        
                                        echo "<div class='alerts'><i class='fas fa-exclamation-circle'></i>  what weight did you use?</div>";
                            
                                    } 
                            
                                ?>
							</div>
					
					
						<div class="col-lg-4 px-2 inputShell">
							<label for="repInput" class="input-label"> rep target: <?php echo $reps?> </label><br>
        		    		<input class="numberInput w-100" name="repsComplete" id="repInput" type="number" placeholder ="<?php echo $reps?>">
							<?php 
							    
							    if(isset($_GET["submit"]) && $_GET["submit"] == "next set" && $_GET["repsComplete"] ==""){
                
                                    echo "<div class='alerts' id='repAlert'><i class='fas fa-exclamation-circle'></i> how many reps did you do?</div>";
                
                                } 
							
							?>
							</div>
							
						<div class="col-lg-4 px-2">
							<label for="rpeInput" class="input-label"> rpe </label><br>
        			        <select class="numberInput w-100" id="rpeInput" name="rpeLevel" type="number">
						        <option>10: 0 more reps or bad form</option>
						        <option>9.5: Maybe 1 more rep</option>
					     	    <option>9: Definitely 1 more rep</option>
						        <option>8.5: Maybe 2 more reps</option>
						        <option selected>8: Definitely 2 more reps</option>
					    	    <option>7.5: Maybe 3 more reps</option>
					    	    <option>7: Definitely 3 more reps</option>
					    	    <option>6.5: Maybe 4 more reps</option>
					    	    <option><6: Way more reps. Add weight</option>
                    	    </select>
						</div>
					</div>
				</div>
				
				<input type="submit" name="submit" value="back" class="btn font-weight-bold float-left mt-4 mb-4">
				<input type="submit" name="submit" id="nextSet" value="next set" class="button float-right px-5 mt-4 mb-4">
			</form>
				
		</div>
	  </div>
	 
		<nav class="nav fixed-bottom navbar-expand-lg navbar-dark bg-dark p-1">
			<ul class="navbar-nav d-flex flex-row bd-highlight w-100">
				<li class="nav-item w-25 text-center py-1">
					<a href="index.php" class="nav-link emphasis d-none d-sm-inline" id="navDash"> dashboard </a>
                    <a href="index.php" class="nav-link emphasis d-inline d-sm-none" id="navDash">
                    <i class="far fa-user" style="font-size: 25px;"></i>				
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
	  
	  
 
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
			
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
			
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/script.js"></script>    
    <script type="text/javascript" src="javascript/timer.js"></script>
    <script>
    $("#nextSet").click(function(){
          
    localStorage.setItem('restInterval', rest);
	           
});

        
    </script>

  </body>
</html>