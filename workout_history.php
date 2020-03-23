<?php

    session_start();
        $workoutId = $_SESSION['workoutId']; 
        $workoutDate = $_SESSION['workoutDate'];
        $workoutDiary = $_SESSION['id']."workoutdiary";
        $exerciseRecord = $_SESSION['id']."exerciserecord";
        $idHolder = $_SESSION['id'];
        $date = explode(" ", $workoutDate);
        $newDate = date("d/m/y", strtotime($date[0]));
        $newTime =date("H:i", strtotime($date[1]));


        $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");

        if (!$link) {
               
            die('Connect Error: ' . mysqli_connect_error());
        }
            
        include "./php_functions/logincheck.php";
        
        $query ="SELECT workoutname
                FROM phaserecord 
                WHERE workoutid = ".$workoutId;
                     
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        $query = "SELECT *
                    FROM ".$row['workoutname'];
        
        $result = mysqli_query($link, $query);

        $workoutName = $row['workoutname'];

            $workoutTable = "<tr>
                                <th class='tableHead'> Exercise </th>
                                <th class='tableHead text-center'> Set </th>
                                <th class='tableHead text-center'> Reps </th>
                                <th class='tableHead text-center'> Weight </th>
                                <th class='tableHead text-center'> Reps </th>
                                <th class='tableHead text-center'> RPE </th>
                            </tr>"; 
        
         $query2 = "SELECT weight, reps, rpe 
            FROM ".$exerciseRecord."
            WHERE workoutid = ".$workoutId." 
            AND datecreated = '".$workoutDate."'";
                
        $result2 = mysqli_query($link, $query2);      
        $row2 = mysqli_fetch_array($result2);


        $setDetails =[];
        foreach ($result2 as $value2){ 
            array_push($setDetails, $value2);
        }

       foreach($result as $value){
            
            $rowSelector = $value['id'] - 1;


            $query = "SELECT exercisename 
                        FROM exerciselibrary 
                        WHERE id = ".$value["exercise"];        
            
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);


            $exercise = $row['exercisename'];
           
            $query = "SELECT repscheme 
                        FROM repschemes 
                        WHERE id =".$value["reps"];
           
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);
     
            $reps = $row['repscheme'];


            $workoutTable   .=  "<tr>
                                    <td class='tableDetails'>".$exercise."</td>
                                    <td class='tableBox'>".$value['exerciseset']."</td>
                                    <td class='tableBox'>".$reps."</td>";
                

            $workoutTable .= "<td class='tableBox'>".$setDetails[$rowSelector]['weight']."</td>
                                <td class='tableBox'>".$setDetails[$rowSelector]['reps']."</td>
                                <td class='tableBox'>".$setDetails[$rowSelector]['rpe']."</td>
                            </tr>";
                   
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

    
    <title>MY MGP - Session History</title>
  </head>
  <body>
    
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
			<div class="container col-md-8">		
		  		<a class="navbar-brand align-middle pageTitle mx-0" href="index.php"> 
					<img src="images/logo.png" class="headerLogo mr-2" alt="">
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
		    
		    
		    
		    
        <div class="container col-md-8 mt-4 p-4">
            <h1>Workout History </h1>
            
            <div class="pb-5">
                <h3><?php echo $workoutName; ?></h3>
                <p>Workout from <?php echo $newDate; ?></p>
            
            
                
                <table> 
                    <?php echo $workoutTable; ?>
                </table>
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
					<a href="stats.php" class="nav-link emphasis d-none d-sm-inline active" id="navProg"> progress </a>
    	       	    <a href="stats.php" class="nav-link emphasis d-inline d-sm-none" id="navProg">
    	       	        <i class="fas fa-chart-line active-sm" style="font-size: 25px;"></i>
    	       	    </a>
    	       	</li>
				<li class="nav-item w-25 text-center py-1">
					<a href="select_workout.php" class="nav-link emphasis d-none d-sm-inline" id="navTrain"> add a workout </a>	
	           	    <a href="select_workout.php" class="nav-link emphasis d-inline d-sm-none " id="navTrain">
	           	        <i class="fas fa-dumbbell" style="font-size: 25px;"></i>
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/script.js"></script>    
  </body>
</html>