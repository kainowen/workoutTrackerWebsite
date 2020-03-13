<?php
        
        $level = $_SESSION["level"];
        $workout = $_SESSION["workout"];
        $exercise = $_SESSION["targetExercise"];
        $exerciseId = $_SESSION["exerciseId"];
        $series = $_SESSION["targetseries"];
        $set = $_SESSION["targetSet"];
        $reps = $_SESSION["targetReps"];
        $rest = $_SESSION["targetRest"];
        $notes = $_SESSION["targetNotes"];
        $exerciseQuery = strtolower(str_replace(" ", "", $exercise));
        $exerciseRecord = $_SESSION['id']."exerciserecord";
        $weightPlaceholder = $_SESSION['weightPlaceholder'];
        $setOrder = $_SESSION["setOrder"];

        
        function workoutPopulate($setOrder, $level, $workout, $link){

            $query = "SELECT * FROM ".$level."_rpt_".$workout." WHERE id =".$setOrder;
            
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);

            if (array_key_exists('series', $row)){
                $_SESSION["level"] = $level;
                $_SESSION["workout"] = $workout;
                $_SESSION["targetseries"] = $row['series'].".".$row['seriesorder'];
                $_SESSION["targetExercise"] = $row['exercise'];
                $_SESSION["exerciseId"] = $row['exercise'];
                $_SESSION["targetSet"] = $row['exerciseset'];
                $_SESSION["targetReps"] = $row['reps'];
                $_SESSION["targetRest"] = $row['rest'];
                $_SESSION["targetNotes"] = $row['notes'];
                $_SESSION["setOrder"] = $setOrder;
               
                $query = "SELECT equipmentid FROM exerciselibrary WHERE id =".$_SESSION["targetExercise"];
               
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
        
                $query = "SELECT id FROM equipmentdatabase WHERE id =".$row['equipmentid'];
               
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
        
                if ($row['id'] == 1){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> weight (kg)</label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 50">';	 
                } else if ($row['id'] == 2){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> weight (kg)</label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 25">';	 
                } else if ($row['id'] == 3){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> weight (level) </label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 4">';	 
                } else if ($row['id'] == 4){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> weight (bands) </label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 5">';	 
                } else if ($row['id'] == 5){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> bodyweight </label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 0">';	 
                } else if ($row['id'] == 6){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> weight (trx) </label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 0">';	 
                } else if ($row['id'] == 7){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> weight (swiss ball) </label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 0">';	 
                } else if ($row['id'] == 8){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> weight (kg) </label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 25">';	 
                } else if ($row['id'] == 9){
                    $weightPlaceholder ='<label for="weightInput" class="input-label"> weight (kg) </label><br>
                		    			<input class="numberInput w-100" name="weightUsed" step="0.5" id="weightInput" type="number" placeholder="e.g 50">';	 
                };
               
                $_SESSION['weightPlaceholder'] = $weightPlaceholder;
               
                $query = "SELECT exercisename FROM exerciselibrary WHERE id =".$_SESSION["targetExercise"];
               
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
         
                $_SESSION["targetExercise"] = $row['exercisename'];
               
               
                $query = "SELECT repscheme FROM repschemes WHERE id =".$_SESSION["targetReps"];
               
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
         
                $_SESSION["targetReps"] = $row['repscheme'];

            } else {
                        
                header("Location: summary.php");  
                     
            }
        }


?>