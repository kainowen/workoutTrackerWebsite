<?php

    session_start();
        $level = $_SESSION["level"];
        $workout = $_SESSION["workout"];
        $_SESSION['setDetails2']  = [];
        $exerciseRecord = $_SESSION['id']."exerciserecord";
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
            
    include "logincheck.php";
        
        $query ="SELECT *
                FROM ".$level."_rpt_".$workout; 
 
                
                     
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        
            $workoutTable = "<tr>
                                    <th class='tableHead'> Exercise </th>
                                    <th class='tableHead'> Set </th>
                                    <th class='tableHead'> Reps </th>
                                    <th class='tableHead'> Weight </th>
                                    <th class='tableHead'> Reps </th>
                                    <th class='tableHead'> RPE </th>
                                </tr>"; 
        
                

                
       foreach($result as $value){

                $workoutTable   .=  "<tr>
                                        <td class='tableDetails'>".$value['exercise']."</td>
                                        <td class='tableDetails'>".$value['exerciseset']."</td>
                                        <td class='tableDetails'>".$value['reps']."</td>";
                
                $exSelector = ($value["id"] - 1);
                $setDetails = unserialize($_SESSION['setDetails'][$exSelector]);
                
                $workoutTable .= "<td class='tableBox weightInput'>".$setDetails[0]."</td>
                                  <td class='tableBox'>".$setDetails[1]."</td>
                                  <td class='tableBox'>".$setDetails[2]."</td>
                              </tr>";
                   
        }
                    
        
            $editTable = "<tr>
                                <th class='tableHead'> Exercise </th>
                                <th class='tableHead'> Set </th>
                                <th class='tableHead'> Reps </th>
                                <th class='tableHead'> Weight </th>
                                <th class='tableHead'> Reps </th>
                                <th class='tableHead'> RPE </th>
                            </tr>"; 
        
                

                
       foreach($result as $value){


                $editTable   .=  "<tr>
                                        <td class='tableDetails'>".$value['exercise']."</td>
                                        <td class='tableDetails'>".$value['exerciseset']."</td>
                                        <td class='tableDetails'>".$value['reps']."</td>";
                
                $exSelector = ($value["id"] - 1);
                $setDetails = unserialize($_SESSION['setDetails'][$exSelector]);

                $editTable .=  "<td><input type='number' step='0.5' value='".$setDetails[0]."' class='editTableBox weightInput' name='weightInput[]'></td>
                                <td><input type='number' value='".$setDetails[1]."' class='editTableBox repInput' name='repInput[]'></td>
                                <td><input type='number' step='0.5' value='".$setDetails[2]."' class='editTableBox rpeInput' name='rpeInput[]'></td>
                            </tr>";
                   
        }            
                    
                    
    if (isset($_POST['submit']) && $_POST['submit'] ==='Confirm'){
        
        $query = "INSERT INTO notificationrecord(userid, notificationid, date_created, details) 
                  VALUES(".$idHolder.", 2, '".$date."', ".$workoutName.")";
                  

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
                
                $exerciseQuery = strtolower(str_replace("-", "", str_replace(" ", "", $value['exercise'])));
                $id = $value['id'] - 1;
                
                $query2 = "SELECT ".$exerciseQuery." 
                             FROM ".$exerciseRecord;
          
                $result2 = mysqli_query($link, $query2);
                $row = mysqli_fetch_array($result2);
                

                if(array_key_exists($exerciseQuery, $row)){
                
                    $query2 = "SELECT ".$exerciseQuery." 
                                 FROM ".$exerciseRecord."
                                 WHERE ".$exerciseQuery." ='' ";
              
                    $result2 = mysqli_query($link, $query2);
                    $row = mysqli_fetch_array($result2);
    

                    if (array_key_exists($exerciseQuery, $row)){
                        
                        header('Location: index.php');
                        
                        $query3 = "UPDATE ".$exerciseRecord."
                                    SET ".$exerciseQuery." = '".$_SESSION['setDetails'][$id]."'
                                    WHERE ".$exerciseQuery." ='' 
                                    LIMIT 1";
                            
                        mysqli_query($link, $query3); 
                        
                       
                        
                    } else {
                          
                        header('Location: index.php');  
                            
                        $query4 =   "INSERT INTO ".$exerciseRecord."
                                    (".$exerciseQuery.")
                                    VALUES ('".$_SESSION['setDetails'][$id]."')";
                             
                        mysqli_query($link, $query4);
                
                    }   
                    
                } else {
                    
                    $query3 = "ALTER TABLE ".$exerciseRecord."
                                ADD ".$exerciseQuery." TEXT NOT NULL DEFAULT('')";
                    
                    mysqli_query($link, $query3);
                    
                    $query2 = "SELECT ".$exerciseQuery." 
                                 FROM ".$exerciseRecord."
                                 WHERE ".$exerciseQuery." ='' ";
              
                    $result2 = mysqli_query($link, $query2);
                    $row = mysqli_fetch_array($result2);
    

                    if (array_key_exists($exerciseQuery, $row)){
                        
                        header('Location: index.php');
                        
                        $query3 = "UPDATE ".$exerciseRecord."
                                    SET ".$exerciseQuery." = '".$_SESSION['setDetails'][$id]."'
                                    WHERE ".$exerciseQuery." ='' 
                                    LIMIT 1";
                            
                        mysqli_query($link, $query3); 

                  
                       
                    } else {
                          
                        header('Location: index.php');  
                            
                        $query4 =   "INSERT INTO ".$exerciseRecord."
                                    (".$exerciseQuery.")
                                    VALUES ('".$_SESSION['setDetails'][$id]."')";
                             
                        mysqli_query($link, $query4);

                    }   
                } 
            }
            
        }              
                    
                    
            
    if (isset($_GET['submit']) && $_GET['submit'] ==='Complete Workout') {
            
        
        $query = "INSERT INTO notificationrecord(userid, notificationid, date_created, details) 
                  VALUES(".$idHolder.", 2, '".$date."', ".$workoutName.")";
                  
        $result = mysqli_query($link, $query);
            
        $query ="SELECT *
                FROM ".$level."_rpt_".$workout; 

        $result = mysqli_query($link, $query);
            
            foreach($result as $value){
                
                $exerciseQuery = strtolower(str_replace("-", "", str_replace(" ", "", $value['exercise'])));
                $id = $value['id'] - 1;
                
                $query2 = "SELECT ".$exerciseQuery." 
                             FROM ".$exerciseRecord;
          
                $result2 = mysqli_query($link, $query2);
                $row = mysqli_fetch_array($result2);
                

                if(array_key_exists($exerciseQuery, $row)){
                
                    $query2 = "SELECT ".$exerciseQuery." 
                                 FROM ".$exerciseRecord."
                                 WHERE ".$exerciseQuery." ='' ";
              
                    $result2 = mysqli_query($link, $query2);
                    $row = mysqli_fetch_array($result2);
    

                    if (array_key_exists($exerciseQuery, $row)){
                        
                        header('Location: index.php');
                        
                        $query3 = "UPDATE ".$exerciseRecord."
                                    SET ".$exerciseQuery." = '".$_SESSION['setDetails'][$id]."'
                                    WHERE ".$exerciseQuery." ='' 
                                    LIMIT 1";
                            
                        mysqli_query($link, $query3); 

                        
                        
                    } else {
                          
                        header('Location: index.php');  
                            
                        $query4 =   "INSERT INTO ".$exerciseRecord."
                                    (".$exerciseQuery.")
                                    VALUES ('".$_SESSION['setDetails'][$id]."')";
                             
                        mysqli_query($link, $query4);

                        
                    }   
                    
                } else {
                    
                    $query3 = "ALTER TABLE ".$exerciseRecord."
                                ADD ".$exerciseQuery." TEXT NOT NULL DEFAULT('')";
                    
                    mysqli_query($link, $query3);
                    
                    $query2 = "SELECT ".$exerciseQuery." 
                                 FROM ".$exerciseRecord."
                                 WHERE ".$exerciseQuery." ='' ";
              
                    $result2 = mysqli_query($link, $query2);
                    $row = mysqli_fetch_array($result2);
    

                    if (array_key_exists($exerciseQuery, $row)){
                        
                        header('Location: index.php');
                        
                        $query3 = "UPDATE ".$exerciseRecord."
                                    SET ".$exerciseQuery." = '".$_SESSION['setDetails'][$id]."'
                                    WHERE ".$exerciseQuery." ='' 
                                    LIMIT 1";
                            
                        mysqli_query($link, $query3); 

                           
                        
                    } else {
                          
                        header('Location: index.php');  
                            
                        $query4 =   "INSERT INTO ".$exerciseRecord."
                                    (".$exerciseQuery.")
                                    VALUES ('".$_SESSION['setDetails'][$id]."')";
                             
                        mysqli_query($link, $query4);
                        
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
    <script src="https://kit.fontawesome.com/83a74e8223.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
    
        .editTableBox, .tableBox{
            
            width: 30px;
            padding: 0;
            margin: 0;
            text-align: center;
            border:none;
        }
        
        .editTableBox:hover, .editTableBox:active {
            
            text-decoration: underline;
            
        }
        
        .weightInput{
            
            width: 50px;
            
        }
    </style>

    
    <title>MY MGP - Wokout Summary</title>
  </head>
  <body>
    
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
			<div class="container col-md-8">		
		  		<a class="navbar-brand align-middle pageTitle mx-0" href="index.html"> 
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
		    
		    
		    
		    
        <div class="container col-md-8 my-4">
            <h1>Workout summary</h1>
            <p>Make sure it all looks right before you save it</p>
            
            
            <form method="post">
                <div id="tableDiv">
                    <table class="displayTable"> 
                        <?php echo $workoutTable; ?>
                    </table>
                    
                    <table class="editTable">
                        <?php echo $editTable; ?>
                    </table>
                </div>
                <input  type ="submit" class="button editTable float-right col-md-2 mb-4" value="Confirm" id="confirm" name="submit">
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
    

    <script type="text/javascript">
        
        $("#editBTN").click(function(){
            
            $(".editTable").toggle();
            $(".displayTable").toggle();
        })
        
    </script>
    
 
  </body>
</html>