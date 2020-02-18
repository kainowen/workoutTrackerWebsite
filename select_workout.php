<?php

    session_start();
    
    $planSelect = $_GET["planSelect"];
    $workoutSelect = $_GET["sessionSelect"];
    $submit = $_GET["submit"];
    $level = strtolower(str_replace("Body", "", str_replace("Plan", "", $planSelect)));
        $level = str_replace(" ", "", $level);
    $workout = strtolower(str_replace("Body", "", $workoutSelect));
        $workout = str_replace(" ", "", $workout);
    $setOrder = 1;
    
    
   if ($submit == "Back"){
       
       header("Location: index.php");
       
   } else if ($submit == "Start Session"){
       
       $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
       
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
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed:500|Noto+Sans:400,700&display=swap" rel="stylesheet">
    <style>

body{
            
            font-family: 'Noto Sans', sans-serif;
            padding: 0;
            margin: 0;
            
        }
        
        .row{
            
            margin-right: 0;
            
        }
        
        h1, h2, h3, h4 {

            font-family: 'Fira Sans Extra Condensed', sans-serif;

        }
        
        .headBanner{
            
            color: white;
            background-color: #4EA5ED;
            padding-left: 30px;
            
        }
        
        #avatar{
            
            width: 40px;
            height: 40px;
            border-radius: 50%;
            position: relative;
 
 
        }

        #navBTN{
            
            position: absolute;
            right: 11px;
            border: 1px solid;
            padding: 3px;
            margin: 4px;
        }
        
        .subHeader{
            
            padding-left: 15px;
            
        }
        
        .btn-next{
            
            background-color: #4EA5ED;
            color: white;
            font-weight: bold;
            width: 150px;
        }
        
        .btn-next:hover{
            
            color: white;
            filter: brightness(80%);
            
        }
        
        .btn-back{
            
            background-color: black;
            color: white;
            font-weight: bold;
            width: 150px;
        }
        
        .btn-black:hover{
            
            color: white;
            filter: brightness(80%);
            
        }
        
        .centered{
            
            text-align: center;
            
        }
        
        .margin-top{
            
            margin-top: 30px;
            
        }
        
        .inputBox{
            
            margin: 5px;
            padding: 5px;
            background-color: white;
        }
        
    </style>
    
    <title>My Secret Diary</title>
  </head>
  <body>
      
        
            <div class="" id="workoutSelector">
                <div class="headBanner row">
                    <h1> SELECT YOUR WORKOUT </h1>
                </div>
                <div class="container centered">
                <form method="$_GET">
                   <div class="row margin-top">
                   <div class="col-sm-4 margin-top">
                        <label for="planSelect"> Select a Phase </label><br>
                        <select class="inputBox" id="planSelect" name="planSelect">
                           <option id="beginnerPlan"> Beginner Plan </option>
                           <option id="intermediatePlan"> Intermediate Plan </option>
                           <option id="advancedPlan"> Advanced Plan </option>
                        </select>
                    </div>   
                    <div class="col-sm-4 margin-top">
                        <label for="sessionSelect"> Select a Workout </label><br>
                        <select class="inputBox" id="sessionSelect" name="sessionSelect" >
                           <option id="upper1"> Upper Body 1 </option>
                           <option id="lower"> Lower Body </option>
                           <option id="upper2"> Upper Body 2</option>
                        </select>
                    </div>
                
                <div class="col-sm-4 margin-top">
                    <input type="submit" name="submit" value="Back" class="btn btn-back">
                    <input type="submit" name="submit" id="start" value="Start Session" class="btn btn-next">
                </div>
                </div>
            </form>
        </div>
    </div>
     
        
        
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
         
            $("#start").click(function(){
	           
	            localStorage.setItem('restInterval', 0);
	           
	        });
        
        
        
    </script>
  </body>
</html>