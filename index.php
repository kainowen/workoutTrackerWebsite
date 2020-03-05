<?php
    
    session_start();

    $alert = [];
    
    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");

    if (!$link) {
           
        die('Connect Error: ' . mysqli_connect_error());
    }

    include "logincheck.php";
    include "workoutreset.php";

    $notificationArray=[];
    
    $query = "SELECT *
              FROM notificationrecord
              WHERE userid = '".$_SESSION['id']."'
              ORDER BY id DESC
              LIMIT 10";
    
    $result = mysqli_query($link, $query);

    foreach($result as $value){
        
       $query2 = "SELECT *
                  FROM notificationtemplate
                  WHERE id = '".$value['notificationid']."'";
                  
        $result2 = mysqli_query($link, $query2);
        $row = mysqli_fetch_array($result2);
        $date = explode(" ", $value["date_created"]);
        $newDate = date("d/m/y", strtotime($date[0]));
        $newTime =date("H:i", strtotime($date[1]));
        $notification = "<div class='activityBlock'>
					        <p class='font-weight-bold'><i class='fas fa-check emphasis pr-2'></i>".$row['title']."</p>
					        <p class='px-4'>".$row['body']." ".$value['details']."</p>
					        <p class='px-4'> <small><span class='pr-2'>".$newTime."</span><span>".$newDate."</span></small></p>
				        </div>";
        
        array_push($notificationArray, $notification); 
            
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

   
    <title>MY MGP - Dashboard</title>
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
	  
	<div class="row mt-4 mx-0">
		<div class="col-md-8 container p-4">
        	<h1> Your dashboard </h1>
			<h4 class="pt-1"> A quick and easy way to see your progress </h4>
            <div id="activityFeed" class="mb-5">
	
				<?php
                
                $i = 1;
                
                foreach($notificationArray as $feed){
                    
                    echo $feed;
                    $i++;
                
                }
                
                if ($i <10){
                    
                    echo "<div class='center'> <p>No More Alerts To Show... Get Busy <p></div>";
                    
                }
                
                ?>
				
					
			</div>
    	</div>
    </div>
    
    <div id="navbar-bottom-source">
    <nav class="nav fixed-bottom navbar-expand-lg navbar-dark bg-dark p-1">
		<ul class="navbar-nav d-flex flex-row bd-highlight w-100">
			<li class="nav-item w-25 text-center py-1">
				<a href="index.php" class="nav-link emphasis d-none d-sm-inline active" id="navDash"> dashboard </a>
                <a href="index.php" class="nav-link emphasis d-inline d-sm-none" id="navDash">
                    <i class="fas fa-tachometer-alt active-sm" style="font-size: 25px;"></i>				
			    </a>
			</li>
			<li class="nav-item w-25 text-center py-1">
				<a href="stats.php" class="nav-link emphasis d-none d-sm-inline" id="navProg"> progress </a>
    	        <a href="stats.php" class="nav-link emphasis d-inline d-sm-none" id="navProg">
    	            <i class="fas fa-chart-line" style="font-size: 25px;"></i>
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
    

    <script type="text/javascript" src="script.js"></script>
    
 
  </body>
</html>