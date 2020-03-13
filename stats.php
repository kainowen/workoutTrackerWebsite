<?php

    session_start();
   
    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");

    if (!$link) {
           
        die('Connect Error: ' . mysqli_connect_error());
    }
    
    include "./php_functions/logincheck.php";
    include "./php_functions/workoutreset.php";

    
    $query = "SELECT weight, bf, arm, hip, waist
              FROM measurementrecords
              WHERE userid = '".$_SESSION['id']."'
              ORDER BY id DESC";

    $result = mysqli_query($link, $query);
    $measurementDetails = [];
    $measurementKeys =[];
    foreach($result as $array){
        foreach($array as $key => $value){
            if($value != 0){
                if(!in_array($key, $measurementKeys)){

                    array_push($measurementDetails, $value);
                    array_push($measurementKeys, $key);

                }
            }        
        }
    }
    
    $query = "SELECT key_lift_1, key_lift_2, key_lift_3, key_lift_4, key_lift_5
              FROM myusers
              WHERE id = '".$_SESSION['id']."'
              LIMIT 5";
      
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    $i = 0;
    $keyLifts =[];
    foreach ($row as $value){
        
        $query2 = "SELECT exercisename FROM exerciselibrary WHERE id =".$row[$i];
               
        $result2 = mysqli_query($link, $query2);
        $row2 = mysqli_fetch_array($result2);
        
        $keyLifts = $row2[0];
        
        $query3 = "SELECT MAX(weight)
                   FROM ".$exerciseRecord."
                   WHERE exerciseid = ".$row[$i];


        $result3 = mysqli_query($link, $query3);
        $row3 = mysqli_fetch_array($result3);

        if ($i < 5){
            if (isset($row3['MAX(weight)'])){
                $keyLift[$keyLifts] = $row3['MAX(weight)'];
            }
        }
        $i++;
    }    

      
    if (isset($_POST['submit'])){
        
        $date = date('Y/m/d H:i:s', time());
        
        $query = "INSERT INTO measurementrecords (userid, date_created)
                  VALUES (".$_SESSION['id'].", '".$date."')";
        
        $result = mysqli_query($link, $query);
 
        $details = "";
        
        foreach($_POST as $key => $value){
            
            if($value != ""){
                $query2 = "UPDATE measurementrecords
                           SET ".$key." = '".$value."'
                           WHERE userid = ".$_SESSION['id']."
                           ORDER BY id DESC
                           LIMIT 1";
                      
                $result2 = mysqli_query($link, $query2);
           
            $details .= $key.", ";
            }
        }
        
        $details = substr($details, 0, -10);
        $details .= '.';
      
        $query = "INSERT INTO notificationrecord (userid, notificationid, date_created, details)
                    VALUES (".$_SESSION['id'].", 4, '".$date."', '".$details."')";
   
        $result = mysqli_query($link, $query);
       
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
    <style></style>
   
    <title>MY MGP - Dashboard</title>
  </head>
  <body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
			<div class="container col-md-8">		
		  		<a class="navbar-brand align-middle pageTitle mx-0" href="index.html"> 
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
	  
	<div class="row my-4 mx-0">
		<div class="col-md-8 container p-4">
        	<h1> Progress </h1>
			<h4 class="pt-1"> Find out how you're improving </h4>


            <div class="activityBlock mb-3 p-3">
                <h4 class="">PROGRESS PICTURES</h4>
                    <div class="row">
                        <img src="" class="statProgressPicture">
                        <img src="" class="statProgressPicture">
                    </div>
            </div>
        
            
            
            <div class="activityBlock mb-3 p-3"> 
                <h4>PERSONAL BESTS</h4>
                <div>
                    <table class="pbTable">
                    <?php
                    
                    foreach($keyLift as $key => $value){
                        echo "<tr>
                                <th class='pbTableHeads'>".$key."</th>
                              </tr>
                              <tr>
                                <td> Heaviest weight lifted: ".$value."kg </td>
                              </tr>";
                       
                    }
                    ?>

                    </table>
                </div>
            </div>
            
            <div class="activityBlock mb-3 p-3"> 
                <div>
                    <h4>MEASUREMENTS</h4> 
                    <a id="measurementUpdate" class="emphasis float-right pointer"> update </a>
                </div>
                <div id="measurementPopUp" class="form-group clearfix">
                    <form method="post">
                        <div class="inputshell">
                            <label for="weighUpdate" class="input-label"> Weight: </label><br>
                            <input type="number" name="weight" step="0.1" id="weightUpdate" class="numberInput w-100" placeholder="type your weight here">
                        </div>
                        <div class="inputshell">
                            <label for="bfUpdate" class="input-label"> Body Fat %: </label>
                            <input type="number" name="bf" step="0.1" id="bfUpdate" class="numberInput w-100" placeholder="type your body fat % here">
                        </div>
                        <div class="inputshell">
                            <label for="armUpdate" class="input-label"> Arm Circumference (cm): </label>
                            <input type="number" name="arm" step="0.1" id="armUpdate" class="numberInput w-100" placeholder="type your arm circumference here">
                        </div>
                        <div class="inputshell">
                            <label for="waistUpdate" class="input-label"> Waist Circumference (cm): </label>
                            <input type="number" name="waist" step="0.1" id="waistUpdate" class="numberInput w-100" placeholder="type your waist circumference here">
                        </div>
                        <div class="inputshell">                       
                            <label for="hipUpdate" class="input-label"> Hip Circumference (cm): </label>
                            <input type="number" name="hip" step="0.1" id="hipUpdate" class="numberInput w-100" placeholder="type your hip circumference here">
                        </div>
                        <input type="submit" name="submit" value="submit" class="button col-md-2 float-right">
                    </form>                    
                </div>
                
                <div class="">
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Body Weight </th>
                        </tr>
                        <tr>
                            <td> <?php echo $measurementDetails[0]."kg"; ?></td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Body Fat % </th>
                        </tr>
                        <tr>
                            <td> <?php echo $measurementDetails[1]."%"; ?> </td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Arm Circumference</th>
                        </tr>
                        <tr>
                            <td> <?php echo $measurementDetails[2]."cm"; ?></td>
                        </tr>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Waist Circumference </th>
                        </tr>
                        <tr>
                            <td> <?php echo $measurementDetails[3]."cm"; ?></td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Hip Circumference </th>
                        </tr>
                        <tr>
                            <td> <?php echo $measurementDetails[4]."cm"; ?></td>
                        </tr>
                    </table>
                    </table>
                </div>
            </div>



    	
    	
    	
    	
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
				<a href="stats.php" class="nav-link emphasis d-none d-sm-inline active" id="navProg"> progress </a>
    	        <a href="stats.php" class="nav-link emphasis d-inline d-sm-none" id="navProg">
    	            <i class="fas fa-chart-line active-sm" style="font-size: 25px;"></i>
    	        </a>
    	    </li>
			<li class="nav-item w-25 text-center py-1">
				<a href="select_workout.php" class="nav-link emphasis d-none d-sm-inline" id="navTrain"> add a workout </a>	
	       	    <a href="select_workout.php" class="nav-link emphasis d-inline d-sm-none" id="navTrain">
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
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/script.js"></script>    
  </body>
</html>