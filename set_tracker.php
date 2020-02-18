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
        

        $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
       
                   if (!$link) {
           
                die('Connect Error: ' . mysqli_connect_error());
            }
       
            
        
    if ($_GET["weightUsed"] !="" && $_GET["repsComplete"] !=""){
        if ($_GET["submit"] == "Next Set"){
            $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
       
            if (!$link) {
           
                die('Connect Error: ' . mysqli_connect_error());
            }
            

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
        
        } else if ($_GET["submit"] == "Back"){
            $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
       
            if (!$link) {
           
                die('Connect Error: ' . mysqli_connect_error());
            }
            
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

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/83a74e8223.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
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
            
            margin-top: 20px;
            
        }
        
        .inputBox{
            
            margin: 5px;
            padding: 5px;
            background-color: white;
            text-align: center;
        }
       
       #setTrackNav{
           
           float: right;
           position: absolute;
           right: 15px;
           text-align: center;
           top: 4%;
           
       }
      
       .setTrackBTN{
           
           height: 30px;
           width: 30px;
           color: white;
           font-size: 20px;
           margin-top: 4%;
           
       }
       
       .setTrackDetails{
           
           padding: 0;
           text-align: left;
           width: 75px;
           margin: 0px 10% 0px 20px;
           font-weight: bold;
           color: white;
           background-color: #4EA5ED;
           border: none;
       }
       
       #rpePopover{
           
           width: 120px;
           
       }
        
    </style>
    <title>My MGP - Set Tracker</title>
  </head>
  <body>
	  
	<div class="">
        <div class="headBanner row">
        	<h3 class="col-sm-5 margin-top"> <?php echo $series." ".$exercise?></h3>
            
    	    <div class="col-sm-4 row centered">
        	    <p class="subHeader setTrackDetails"> <?php echo "Set: ".$set?></p>
    		    <button id="rest" value="<?php echo $rest ?>"class="setTrackDetails">Go</button>
    		    <audio id="beep">
    		        <source src="sounds/beep-07.mp3" type="audio/mpeg">
    		    </audio>
            </div>
            
    		<div id="setTrackNav" class="">
        	    <a id="homeButton" class="setTrackBTN" href="index.php"><i class="fas fa-home"></i></a>
    	    	<p id="popover" class="setTrackBTN" data-container="body" data-html="true" data-toggle="popover" data-placement="left" data-content='<?php echo $record ?>' > i </p>
    	    </div>
            
        </div>
        
        
    	<form method="get" class="centered">
    		<div class="row">
    		    <div class="form-group col-sm-4 margin-top">
        	        <label for="weightInput"> Weight (kg)</label><br>
        		    <input class="inputBox" name="weightUsed" id="weightInput" type="number" placeholder="eg. 50"><br>
        		    
        		    <?php if(isset($_GET["submit"]) && $_GET["submit"] == "Next Set" && $_GET["weightUsed"] ==""){
                
                            echo "<div class='alert alert-danger'>Please enter a weight used</div>";
                
                            } 
                    ?>
                
        		</div>
        	     <div class="form-group col-sm-4 margin-top">
        		    <label for="repInput"> Rep Target: <?php echo $reps?> </label><br>
        		    <input class="inputBox" name="repsComplete" id="repInput" type="number" placeholder ="<?php echo $reps?>"><br>
        		    
        		            <?php if(isset($_GET["submit"]) && $_GET["submit"] == "Next Set" && $_GET["repsComplete"] ==""){
                
                                echo "<div class='alert alert-danger'>Please enter a the number of reps completed</div>";
                
                                } 
       		    ?>
       		    </div>
        	    <div class="form-group col-sm-4 margin-top">
        		   <label for="rpeInput"> RPE </label>
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
        		         </div>

        		        "> i </span><br>
        		        <input class="inputBox" id="rpeInput" name="rpeLevel" type="float" placeholder="8"><br>
        		    </div>
        		</div>
        		<input type="submit" name="submit" value="Back" class="btn margin-top btn-back">
                <input type="submit" name="submit" id="nextSet" value="Next Set" class="btn btn-next margin-top"><br>
                <p id="notesDiv" class="">Notes: <?php echo $notes ?></p>
    		</form>
        </div> 
	</div>
	  
	  
 
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
			
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
			
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	  <script>
	     
              
            var rest = $("#rest").val();
            
            var restTime = localStorage.getItem("restInterval");

	            setInterval(function(){
	             
	                restTime = restTime - 1;
	       
	                if (restTime > 0){
	       
	                    $('#rest').html(restTime + " secs");
	          
	                } else {
	          
                        $('#rest').html('Go');
	       
	                }
	                
	                if (restTime === 10 || restTime === 3 || restTime === 2 || restTime === 1|| restTime === 0){
	                 	               
                            
                                $("audio#beep")[0].play();
                            
	                }
	          
	            }, 1000);
	        
            
	       
	      $("#nextSet").click(function(){
	           
	           localStorage.setItem('restInterval', rest);
	           
	       });
	       
            	      
            $(function () {
              $('[data-toggle="popover"]').popover()
            })
	      
	      
	  </script>
  </body>
</html>