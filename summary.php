<?php

    session_start();
    
        $level = $_SESSION["level"];
        $workout = $_SESSION["workout"];
        $_SESSION['setDetails2']  = [];
        $exerciseRecord = $_SESSION['id']."exerciserecord";

        $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");
    
        if (!$link) {
               
            die('Connect Error: ' . mysqli_connect_error());
        }
            
        
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

                $workoutTable .= "<td>".$setDetails[0]."</td>
                                  <td>".$setDetails[1]."</td>
                                  <td>".$setDetails[2]."</td>
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

                $editTable .=  "<td><input type='number' value='".$setDetails[0]."' class='tableBox weightInput' name='weightInput[]'></td>
                                <td><input type='number' value='".$setDetails[1]."' class='tableBox repInput' name='repInput[]'></td>
                                <td><input type='number' value='".$setDetails[2]."' class='tableBox rpeInput' name='rpeInput[]'></td>
                            </tr>";
                   
        }            
                    
                    
    if (isset($_POST['submit']) && $_POST['submit'] ==='Confirm'){
        
        $i = 0;  

        while ($i < count($_POST['weightInput'])){
                
                $setSave = [];
                
                array_push($setSave, $_POST['weightInput'][$i]);
                array_push($setSave, $_POST['repInput'][$i]);
                array_push($setSave, $_POST['rpeInput'][$i]);
                
                $i++;
                $setSave = serialize($setSave);
                array_push($_SESSION['setDetails2'], $setSave);
            }
            
            $query ="SELECT *
                     FROM ".$level."_rpt_".$workout; 

            $result = mysqli_query($link, $query);
            
            foreach($result as $value){
                
                $exerciseQuery = strtolower(str_replace("-", "", str_replace(" ", "", $value['exercise'])));
                $id = $value['id'] - 1;
                
                $query2 = "SELECT ".$exerciseQuery." 
                             FROM ".$exerciseRecord."
                             WHERE ".$exerciseQuery." ='' ";
          
                $result2 = mysqli_query($link, $query2);
                $row = mysqli_fetch_array($result2);

                
                if (array_key_exists($exerciseQuery, $row)){
                    
                    header('Location: index.php');
                    
                    $query3 = "UPDATE ".$exerciseRecord."
                                SET ".$exerciseQuery." = '".$_SESSION['setDetails2'][$id]."'
                                WHERE ".$exerciseQuery." ='' 
                                LIMIT 1";
                        
                    mysqli_query($link, $query3); 
                    
                    
                    
                } else {
                      
                    header('Location: index.php');  
                        
                    $query4 =   "INSERT INTO ".$exerciseRecord."
                                (".$exerciseQuery.")
                                VALUES ('".$_SESSION['setDetails2'][$id]."')";
                         
                    mysqli_query($link, $query4);
                      echo $query;
                }   
            } 
        
        }              
                    
                    
            
    if (isset($_GET['submit']) && $_GET['submit'] ==='Complete Workout') {
            
            $query ="SELECT *
                    FROM ".$level."_rpt_".$workout; 

                $result = mysqli_query($link, $query);
            
            foreach($result as $value){
                
                $exerciseQuery = strtolower(str_replace("-", "", str_replace(" ", "", $value['exercise'])));
                $id = $value['id'] - 1;
                
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
            
    
?>

<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/83a74e8223.js" crossorigin="anonymous"></script>
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed:500|Noto+Sans:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
        }
       
       #setTrackNav{
           
           float: right;
           position: absolute;
           right: 15px;
           text-align: center;
           top: 25px;
           
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
        
        #tableDiv{
            
            height: 500px;
            overflow-y: scroll;
            
        }
        
        td, th{
            
            padding-right: 5px;
            
        }
        
        .editTable{
            
            display: none;
            
        }
        
        .tableBox{
            
            width: 30px;
            height: 22px;
            padding: 0;
            text-align: center;
            border: none;
       
        }
        
    </style>

    
    <title>MY MGP - Wokout Summary</title>
  </head>
  <body>
    
 
    <div class="">
		    <div class="headBanner row">
		        <div id="setTrackNav">
		            <a id="homeButton" class="setTrackBTN" href="index.php"><i class="fas fa-home"></i></a>
                </div>
                <h2 class="col-md-8 margin-top"> Workout Summary </h2>
            </div>
        <div class="container">  
            <form method="post">
                <div id="tableDiv">
                    <table class="margin-top displayTable"> 
                        <?php echo $workoutTable; ?>
                    </table>
                    
                    <table class="margin-top editTable">
                        <?php echo $editTable; ?>
                    </table>
                </div>
                <input  type ="submit" class="btn btn-back margin-top editTable" value="Confirm" id="confirm" name="submit">
            </form>
            
            <form method="get">
                <input  class="btn btn-back margin-top displayTable" value="Edit Workout" id="editBTN">
                <input  type ="submit" class="btn btn-next margin-top displayTable" value="Complete Workout" id="completeBTN" name="submit">
            </form>
        </div>
    </div>
    
    
    
    
    
    

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