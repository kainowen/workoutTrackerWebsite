<?php
    session_start();
        
        $level = $_SESSION["level"];
        $workout = $_SESSION["workout"];
        $exercise = $_SESSION["targetExercise"];
        $series = $_SESSION["targetseries"];
        $set = $_SESSION["targetSet"];
        $reps = $_SESSION["targetReps"];
        $rest = $_SESSION["targetRest"];
        $notes = $_SESSION["targetNotes"];
        $setOrder = $_SESSION["setOrder"];
        $exerciseQuery = strtolower(str_replace(" ", "", $exercise));
        $exerciseRecord = $_SESSION['id']."exerciserecord";
        
        if (($_SESSION['level'] === '') ){

            header("location: select_workout.php");
            
        }   

        $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
       
        if (!$link) {
            
            die('Connect Error: ' . mysqli_connect_error());
        
        }
       
            
        
        if ($_GET["weightUsed"] != "" && $_GET["repsComplete"] !=""){
            
            if ($_GET["submit"] == "next set"){
           
                $setDetails1=[];
                array_push($setDetails1, $_GET["weightUsed"], $_GET["repsComplete"], $_GET["rpeLevel"]);
                    
                $setDetails2 = serialize($setDetails1);
                array_push($_SESSION['setDetails'], $setDetails2);
                
                $setOrder++;    
                $query = "SELECT * FROM ".$level."_rpt_".$workout." WHERE id =".$setOrder;
              
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
                
                if (array_key_exists('series', $row)){
                    $_SESSION["level"] = $level;
                    $_SESSION["workout"] = $workout;
                    $_SESSION["targetseries"] = $row['series'].".".$row['seriesorder'];
                    $_SESSION["targetExercise"] = $row['exercise'];
                    $_SESSION["targetSet"] = $row['exerciseset'];
                    $_SESSION["targetReps"] = $row['reps'];
                    $_SESSION["targetRest"] = $row['rest'];
                    $_SESSION["targetNotes"] = $row['notes'];
                    $_SESSION['setOrder'] = $setOrder;
                    
                    $exercise = $_SESSION["targetExercise"];
                    $series = $_SESSION["targetseries"];
                    $set = $_SESSION["targetSet"];
                    $reps = $_SESSION["targetReps"];
                    $rest = $_SESSION["targetRest"];
                    $notes = $_SESSION["targetNotes"];
                   
                    
                } else {
                    
                 header("Location: summary.php");  
                 
                }
                
            }
        
        } else if ($_GET["submit"] == "back"){
            
            if ($setOrder > 1){
                $setOrder = $_SESSION["setOrder"];
                $setOrder--;    
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
                
                $exercise = $_SESSION["targetExercise"];
                $series = $_SESSION["targetseries"];
                $set = $_SESSION["targetSet"];
                $reps = $_SESSION["targetReps"];
                $rest = $_SESSION["targetRest"];
                $notes = $_SESSION["targetNotes"];
                
                array_pop($_SESSION['setDetails']);
                
            } else {
                
                header("Location: select_workout.php");
                
            }
        
        }
        
        $exerciseQuery = strtolower(str_replace(" ", "", $exercise));
            
                
        $query ="SELECT ".$exerciseQuery."
                FROM ".$exerciseRecord."
                WHERE ".$exerciseQuery." != ''
                ORDER BY id DESC
                LIMIT 5";
                         
        $result = mysqli_query($link, $query);
                
        $row = [];
                
        $record = "<strong>Lift History: </strong><br>";
                
        $i = 0;
                
        foreach ($result as $value){
        
            $value = unserialize($value[$exerciseQuery]);
            array_push($row, $value);
        
            if ($i == 0){
                       
                $record .= "<strong>Weight: ".$row[$i][0]." X Reps: ".$row[$i][1]." @ RPE: ".$row[$i][2]."</strong><br>";
                   
            } else {
                       
                $record .= "Weight: ".$row[$i][0]." X Reps: ".$row[$i][1]." @ RPE: ".$row[$i][2]."<br>";
                       
            }
                 
            $i++;
                
        };
              
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
	    
	    .alerts{
	        
	        background-color: red;
	        border-radius: 25px 25px 15px 15px;
	        padding: 55px 30px 5px 30px;
	        margin-top: -50px;
	        color: white;
	   
	    }
	    
	    .input-alert{
	        
	        border: 3px solid red;
	        padding: 27px;
	        
	    }
	    
	    input{
	        
	        outline: 0;
	        border: 0;
	        
	    }
	    
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
	  
	  	<div class="row my-3 mx-0">
			<div class="col-md-8 container p-4">
        		<h1 id="set"> <?php echo "Set: ".$set?> </h1>
				<h4 class="pt-1">Workout: <strong> Advanced Plan, Upper Body 1</strong></h4>
	  			<h4 class="pt-1 d-inline">Exercise: <strong> <?php echo $series." ".$exercise?> </strong></h4>
	  			    <p id="popover" class="d-inline align-bottom" data-container="body" data-html="true" data-toggle="popover" data-placement="right" data-content='<?php echo $record ?>' > <i class="fas fa-info-circle emphasis pointer"> </i></p>
				
				<div class="activityBlock bg-dark text-white mt-3 px-3 pt-3 clearfix timer">
					<div class="float-left">
						<h5><strong> Timed break</strong></h5>
						<p> Before you start again we advice taking a timed break</p>
						<input class="d-none"type="checkbox" value="<?php echo $rest ?>" id="rest">
					</div>
					<h2 id="restTimer" class="emphasis float-lg-right float-left m-2">start</h2>
					<audio id="beep">
    		        	<source src="sounds/beep-07.mp3" type="audio/mpeg">
    		    	</audio>
				</div>
				
				
				
				<form method="get">
					<div class="activityBlock mt-4 p-4">
						
						<div class="row">
							
							<div class="col-sm-4 py-2">
								<label for="weightInput"> weight (kg)</label><br>
        		    			<input class="numberInput w-75" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="eg. 50">			 
							    <?php 
        		        
                    		        if(isset($_GET["submit"]) && $_GET["submit"] == "next set" && $_GET["weightUsed"] ==""){
                                        
                                        echo "<div class='alerts w-75'>please type the weight used</div>";
                            
                                    } 
                            
                                ?>
							</div>
					
					
						<div class="col-sm-4 py-2">
							<label for="repInput"> rep Target: <?php echo $reps?> </label><br>
        		    		<input class="numberInput w-75" name="repsComplete" id="repInput" type="number" placeholder ="<?php echo $reps?>">
							<?php 
							    
							    if(isset($_GET["submit"]) && $_GET["submit"] == "next set" && $_GET["repsComplete"] ==""){
                
                                    echo "<div class='alerts w-75'>please type the number of reps done</div>";
                
                                } 
							
							?>
							</div>
							
						<div class="col-sm-4 py-2">
							<span data-container="body" data-html="true" data-toggle="popover" data-placement="right" 
    	    		        data-content="<div id='rpePopover'><strong> RPE Scale: </strong><br> 
 	    	   		        10: 0 more reps or bad form<br>
        			        9.5: Maybe 1 more rep<br>
        			         9: Definitely 1 more rep<br> 
        		    	     8.5: Maybe 2 more reps<br> 
        		    	     8: Definitely 2 more reps<br> 
        		    	     7.5: Maybe 3 more reps<br> 
        		    	     7: Definitely 3 more reps<br> 
        		    	     6.5: Maybe 4 more reps<br> 
        		    	     6: Definitely 4 more reps<br> 
        		    	     <6: Way more reps. Add weight<br> 
        		    	     </div>"> <i class="fas fa-info-circle emphasis pointer"></i> </span>
							<label for="rpeInput"> rpe </label><br>
        			        <input class="numberInput w-75" id="rpeInput" step="0.5" name="rpeLevel" type="number" placeholder="8">
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
                            <i class="fas fa-tachometer-alt" style="font-size: 30px;"></i>				
					    </a>
					</li>
					<li class="nav-item w-25 text-center py-1">
						<a href="stats.php" class="nav-link emphasis d-none d-sm-inline" id="navProg"> progress </a>
    	        	    <a href="stats.php" class="nav-link emphasis d-inline d-sm-none" id="navProg">
    	        	        <i class="fas fa-chart-line" style="font-size: 30px;"></i>
    	        	    </a>
    	        	</li>
					<li class="nav-item w-25 text-center py-1">
						<a href="select_workout.php" class="nav-link emphasis d-none d-sm-inline active" id="navTrain"> add a workout </a>	
	            	    <a href="select_workout.php" class="nav-link emphasis d-inline d-sm-none " id="navTrain">
	            	        <i class="fas fa-dumbbell active-sm" style="font-size: 30px;"></i>
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
	  
	  
 
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
			
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
			
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script type="text/javascript" src="script.js"></script>
  </body>
</html>