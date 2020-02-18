<?php

    session_start();
    
      
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
        
        h1, h2, h3, h4 {

            font-family: 'Fira Sans Extra Condensed', sans-serif;

        }
        
        .headBanner{
            
            color: white;
            background-color: #4EA5ED;
            padding-left: 30px;
            margin-right: 0;
        }
        
        #avatar{
            
            width: 40px;
            height: 40px;
            border-radius: 50%;
            position: relative;
 
 
        }

        .navBTN{
            
            position: absolute;
            right: 11px;
            padding: 0;
            margin: 0;
        }
        
        #dropdown{
            
            margin-top: 15px;
            background-color: #4EA5ED;
            border: none;
            padding: 0;
        }
        
        .dropdown-item{
            
            font-weight: bold;
            color: white;
            border-bottom: solid 1px #99B5C9;
            
        }
        
        .subHeader{
            
            padding-left: 15px;
            
        }
        
        #activityFeed{
            
            height: 520px;
            overflow-y: scroll;
            
        }
        
        .activityBlock{
        
            border: solid 1px gray;
            margin-bottom: 5px;
            padding-left: 5px;
            clear: both;
    
        }
    
        .activityBanner {
            
            font-family: 'Fira Sans Extra Condensed', sans-serif;
            background-color:#317AAE ;
            color: white;
            margin-left: -5px;
            padding-left: 5px;
        }
        
        
        .activityDate{
            
            background-color:#99B5C9 ;
            color: white;
            margin-left: -5px;
            margin-bottom: 0;
            padding-left: 5px;
            height: 20px;
            font-size: 10px;
            
        }
        
        .nav-link{
            
            width: 50%;
            height: 60px;
            color: white;
            background-color: #4EA5ED;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            position: relative;
            
        }
        
        .nav-link:hover{
            
            color: white;
            filter: brightness(80%);
            
        }
        
        
        #navTrain{
            
            width: 80px;
            height: 80px;
            position: absolute;
            left: 50%;
            top: -20px;
            padding-top: 16px;
            margin-left: -40px;
            background-color: black;
            border: solid 10px white;
            border-radius: 50%;
            z-index: 1;
            
        }
        
        .navBlock{
         
            height: 70px;   
            
        }
        
        #learnBody{
            
            height: 500px;
            overflow-y: scroll;
            
        }
        
        .lessonLink{
            
            color: white;
            padding: 5px 0 5px 15px;
        }
        
        .lessonList{
            
            display: none;
            
        }
        
        #featuredArticle{
            
            height: 200px;
            padding: 10px;
            background-color: black;
            color: white;
        }
        
        .centered{
            
            text-align: center;
            
        }
        
        .statProgressPicture{
            
            padding: 0;
            margin: 5px 5px 5px 15px;
            width: 160px;
            height: 240px;
            background-color: #99B5C9;
            
        }
        
        .pbTable{

            margin-right: 7px;
            margin-top: 7px;
            width: 60px;
            
        }
        
        .pbTableHeads {
            
            padding-left: 5px;
            padding-right: 5px;
            background-color: #4EA5ED;
            color: white;
            
        }
        
        
    </style>
    
    <title>MY MGP - Progress</title>
  </head>
  <body>
    
    <div>
        <div class="headBanner row">
            <h1> PROGRESS </h1>
            <div class="dropleft navBTN">
                    <button id="" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img id="avatar" src="images/selfie.jpg"></button>
                    <div id="dropdown" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">My Account</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Settings</a>
                    </div>
                </div>        
            </div>
        </div>
        <div class="container row">
            
            <div class=" col-sm-6">
                <h4 class="">PROGRESS PICTURES</h4>
                    <div class="row">
                        <img src="" class="statProgressPicture beforePic">
                        <img src="" class="statProgressPicture afterPic">
                    </div>
            </div>
        
            
            
            <div class="col-sm-3"> 
                <h4 class="">PERSONAL BESTS</h4>
                <div class="row subHeader">
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Lift </th>
                        </tr>
                        <tr>
                            <td> weight </td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Lift </th>
                        </tr>
                        <tr>
                            <td> weight </td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Lift </th>
                        </tr>
                        <tr>
                            <td> weight </td>
                        </tr>
                        <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Lift </th>
                        </tr>
                        <tr>
                            <td> weight </td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Lift </th>
                        </tr>
                        <tr>
                            <td> weight </td>
                        </tr>
                    </table>
                    </table>
                </div>
            </div>
            
            <div class="col-sm-3"> 
                <h4 class="">MEASUREMENTS</h4>
                <div class="row subHeader">
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Body Weight </th>
                        </tr>
                        <tr>
                            <td> Measurement </td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Body Fat % </th>
                        </tr>
                        <tr>
                            <td> Measurement </td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Arm Circumference</th>
                        </tr>
                        <tr>
                            <td> Measurement </td>
                        </tr>
                        <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Waist Circumference </th>
                        </tr>
                        <tr>
                            <td> Measurement </td>
                        </tr>
                    </table>
                    <table class="pbTable">
                        <tr>
                            <th class="pbTableHeads"> Hip Circumference </th>
                        </tr>
                        <tr>
                            <td> Measurement </td>
                        </tr>
                    </table>
                    </table>
                </div>
            </div>
            
        </div>
            
            
            
            
            
        </div>
        <div class="navBlock"></div>
        <nav class="nav row fixed-bottom">
           
    
            <a href="index.php" class="nav-link btn col-sm" id="navHome"> Home </a>
            <a href="select_workout.php" class="nav-link btn" id="navTrain"> + </a>
            <a href="learn.php" class="nav-link btn col-sm" id="navInfo"> Learn </a>
    
        </nav>
        
    </div>
    
    
    
    
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    

    <script type="text/javascript">

        
    $('.nav-link').click(function(e) {
        e.preventDefault();
        setTimeout(function(url) { window.location = url }, 1210, this.href);
    });

    $(".nav-link").click(function(){ 
          
            //$("#navBrowse").animate({height: '+=10%', width: '+=10%'});
          
            $("#navHome").animate({top: '100px'}, 300);
          
            $("#navInfo").stop().delay(200).animate({top: '100px'}, 300);
              
            $("#navTrain").stop().delay(400).animate({top: '100px'}, 300);
           
        });
      
     
    </script>
    
 
  </body>
</html>