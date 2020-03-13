<?php

    session_start();
        $level = $_SESSION["level"];
        $workout = $_SESSION["workout"];
        $_SESSION['setDetails2']  = [];
        $exerciseRecord = $_SESSION['id']."exerciserecord";
        $workoutDiary = $_SESSION['id']."workoutdiary";
        $workoutName = "'".$level.", ".$workout."'";
        $idHolder = $_SESSION['id'];
        $date = date('Y-m-d H:i:s', time());

        $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");

        if (!$link) {
               
            die('Connect Error: ' . mysqli_connect_error());
        }
            
        if (($_SESSION['level'] === '') ){

            header("location: select_workout.php");
            
        }    
            
    include "./php_functions/logincheck.php";
        
        $query ="SELECT *
                FROM ".$level."_rpt_".$workout; 
 
                
                     
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        
            $workoutTable = "<tr>
                                    <th > Exercise </th>
                                    <th class='text-center'> Set </th>
                                    <th class='text-center'> Reps </th>
                                    <th class='text-center'> Weight </th>
                                    <th class='text-center'> Reps </th>
                                    <th class='text-center'> RPE </th>
                                </tr>"; 
        
                

                
       foreach($result as $value){

        $query = "SELECT exercisename FROM exerciselibrary WHERE id = ".$value["exercise"];        
        
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
 
        $exercise = $row['exercisename'];
       
       
        $query = "SELECT repscheme FROM repschemes WHERE id =".$value["reps"];
       
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
 
        $reps = $row['repscheme'];
      
                $workoutTable   .=  "<tr>
                                        <td class='tableDetails'>".$exercise."</td>
                                        <td class='tableBox text-center'>".$value['exerciseset']."</td>
                                        <td class='tableBox text-center'>".$reps."</td>";
                
                $exSelector = ($value["id"] - 1);
                $setDetails = unserialize($_SESSION['setDetails'][$exSelector]);
                
                $workoutTable .= "<td class='tableBox text-center'>".$setDetails[0]."</td>
                                  <td class='tableBox text-center'>".$setDetails[1]."</td>
                                  <td class='tableBox text-center'>".$setDetails[2]."</td>
                              </tr>";
                   
        }
                    
        $query ="SELECT *
                FROM ".$level."_rpt_".$workout; 
 
                
                     
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
                       
            $editTable = "<tr>
                                <th> Exercise </th>
                                <th class='text-center'> Set </th>
                                <th class='text-center'> Reps </th>
                                <th class='text-center'> Weight </th>
                                <th class='text-center'> Reps </th>
                                <th class='text-center'> RPE </th>
                            </tr>"; 
        
                

                
       foreach($result as $value){


        $query = "SELECT exercisename FROM exerciselibrary WHERE id = ".$value["exercise"];        
        
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
 
        $exercise = $row['exercisename'];
       
       
        $query = "SELECT repscheme FROM repschemes WHERE id =".$value["reps"];
       
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
 
        $reps = $row['repscheme'];

                $editTable   .=  "<tr>
                                        <td class='tableDetails'>".$exercise."</td>
                                        <td class='tableBox'>".$value['exerciseset']."</td>
                                        <td class='tableBox'>".$reps."</td>";
                
                $exSelector = ($value["id"] - 1);
                $setDetails = unserialize($_SESSION['setDetails'][$exSelector]);

                $editTable .=  "<td class='tableBox text-center'><input type='number' step='0.5' value='".$setDetails[0]."' class='editTableBox' name='weightInput[]'></td>
                                <td class='tableBox text-center'><input type='number' value='".$setDetails[1]."' class='editTableBox' name='repInput[]'></td>
                                <td class='tableBox text-center'><input type='number' step='0.5' value='".$setDetails[2]."' class='editTableBox' name='rpeInput[]'></td>
                            </tr>";
                   
        }            
                    
                    
                    
                    
                    
                    
    if (isset($_GET['submit']) && $_GET['submit'] === 'Complete Workout'){
        
        header("location: index.php");
        
        $query = "INSERT INTO notificationrecord(userid, notificationid, date_created, details) 
                  VALUES(".$userId.", 2, '".$date."', ".$workoutName.")";
                  
        $result = mysqli_query($link, $query);
            
            
            $query ="SELECT *
                     FROM ".$level."_rpt_".$workout; 

            $result = mysqli_query($link, $query);
            
            foreach($result as $value){
                
                $id = $value['id'] - 1;
                
                $setDetails = unserialize($_SESSION['setDetails'][$id]);

                $query2 = "INSERT INTO ".$exerciseRecord."
                            (workoutid, exerciseid, weight, reps, rpe, datecreated)
                            VALUES (".$value['workoutid'].",
                                    ".$value['exercise'].",
                                     ".$setDetails[0].",
                                     ".$setDetails[1].", 
                                     ".$setDetails[2].",
                                     '".$date."')";
                
                $result2 = mysqli_query($link, $query2);

            }

            $query3 = "INSERT INTO ".$workoutDiary."(workoutid, datecreated) 
                        VALUES(".$value['workoutid'].", '".$date."')";
        
            $result3 = mysqli_query($link, $query3);

            
            
        }              
                    
                    
            
    if (isset($_POST['submit']) && $_POST['submit'] ==='Confirm') {
            
        header("location: index.php");    
        
        $query = "INSERT INTO notificationrecord(userid, notificationid, date_created, details) 
                VALUES(".$userId.", 2, '".$date."', ".$workoutName.")";
                  

        $result = mysqli_query($link, $query);
        
        $i = 0;  
        $_SESSION['setDetails'] = [];
        while ($i < count($_POST['weightInput'])){
                
                if (isset($_POST['weightInput'])){
                    
                    $setSave = [];
                
                    array_push($setSave, $_POST['weightInput'][$i]);
                    array_push($setSave, $_POST['repInput'][$i]);
                    array_push($setSave, $_POST['rpeInput'][$i]);
                    
                    $setSave = serialize($setSave);
                    array_push($_SESSION['setDetails'], $setSave);

                }
                $i++;
            }
            
            $query ="SELECT *
                     FROM ".$level."_rpt_".$workout; 

            $result = mysqli_query($link, $query);
            
            foreach($result as $value){
                
                $id = $value['id'] - 1;
                
                
                $query2 = "INSERT INTO ".$exerciseRecord."
                            (workoutid, exerciseid, weight, reps, rpe, datecreated)
                            VALUES (".$value['workoutid'].",
                                    ".$value['exercise'].",
                                     ".$setDetails[0].",
                                     ".$setDetails[1].", 
                                     ".$setDetails[2].",
                                     '".$date."')";
                
                $result2 = mysqli_query($link, $query2);
                

                $query3 = "INSERT INTO ".$workoutDiary."(workoutid, datecreated) 
                            VALUES(".$value['workoutid'].", '".$date."')";
        
                $result3 = mysqli_query($link, $query3);

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
        
        .editTableBox{
            width: 50px;
            border: none;
        }

    </style>

    
    <title>MY MGP - Wokout Summary</title>
  </head>
  <body>
    
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
			<div class="container col-md-8">		
		  		<a class="navbar-brand align-middle pageTitle mx-0" href="index.php"> 
					<img src="images/logo.png" class="headerLogo mr-2" alt="">
		  			Welcome back!
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
		    
		    
		    
		    
        <div class="container col-md-8 mt-4 p-4">
            <h1>Workout summary</h1>
            <p>Make sure it all looks right before you save it</p>
            
            
            <form method="post">
                <div>
                    <table class="displayTable"> 
                        <?php echo $workoutTable; ?>
                    </table>
                    
                    <table class="editTable">
                        <?php echo $editTable; ?>
                    </table>
                </div>
                <input  type ="submit" class="button editTable float-right col-md-2 mb-5 mt-2" value="Confirm" id="confirm" name="submit">
            </form>
            
            <form method="get" class="clearfix mt-2 mb-5">
                <input  class="btn font-weight-bold displayTable float-left mb-2 text-lg-left col-lg-3" value="Edit Workout" id="editBTN">
                <input  type ="submit" class="button displayTable col-lg-3 text-center float-right" value="Complete Workout" id="completeBTN" name="submit">
            </form>
        </div>
        
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/script.js"></script>    

  </body>
</html>