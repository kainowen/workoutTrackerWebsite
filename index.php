<?php
    
    session_start();
    
    $email = $_SESSION['email'];
    $alert = [];
    
    
    
    if (isset($_POST["logout"])){

        setcookie("workoutTracker", "", time()- 3600, "/");
        header("Location: signup.php");

    }
    
    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");

    if (!$link) {
           
        die('Connect Error: ' . mysqli_connect_error());
    }


    $query = "SELECT id, email, Name
                FROM myusers
                WHERE email ='".$email."'";
              
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    
    $_SESSION['id'] = $row['id'];
    
    if (array_key_exists('email', $row) && $row['Name'] !== ""){
                    
        $userID = $row['Name'];
        
    } else if (array_key_exists('email', $row) && $row['Name'] === ""){
                    
        $userID = $row['email'];
        
    } else {
        
        header("Location: signup.php");
        
    }
    
      
?>

<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <script src="https://kit.fontawesome.com/83a74e8223.js" crossorigin="anonymous"></script>
    
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
            right: 0;
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
      
    
        
    </style>
   
    <title>MY MGP</title>
  </head>
  <body>
    
    <div>
       
            <div class="row headBanner">
                <h1>HOME </h1>
               
                <div class="dropleft navBTN">
                    <button id="" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img id="avatar" src="images/selfie.jpg"</i></button>
                    <div id="dropdown" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <p class="dropdown-item" > Logged in as: <br> <?php echo $userID ?></p>
                        <a class="dropdown-item" href="#">My Account</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <form method="post">
                            <input type ="submit" class="dropdown-item" name="logout" value="Logout">
                        </form>
                    </div>
                </div>
            </div>
            
            <h3 class="subHeader"> ACTIVITY </h3>
            <div id="activityFeed" class="container">
                <div class="activityBlock">
                    <h5 class="activityBanner"> TITLE </h5>
                    <p> Information about what happened </p>
                    <p  class="activityDate"  > Time: 00:00, Date: 00/00/00</p>
                </div>
                <div class="activityBlock">
                    <h5 class="activityBanner"> TITLE </h5>
                    <p> Information about what happened </p>
                    <p class="activityDate" > Time: 00:00, Date: 00/00/00</p>
                </div>
                <div class="activityBlock">
                    <h5 class="activityBanner"> TITLE </h5>
                    <p> Information about what happened </p>
                    <p class="activityDate"> Time: 00:00, Date: 00/00/00</p>
                </div>
                <div class="activityBlock">
                    <h5 class="activityBanner"> TITLE </h5>
                    <p> Information about what happened </p>
                    <p class="activityDate"> Time: 00:00, Date: 00/00/00</p>
                </div>
                <div class="activityBlock">
                    <h5 class="activityBanner"> TITLE </h5>
                    <p> Information about what happened </p>
                    <p class="activityDate"> Time: 00:00, Date: 00/00/00</p>
                </div>
                <div class="activityBlock">
                    <h5 class="activityBanner"> TITLE </h5>
                    <p> Information about what happened </p>
                    <p class="activityDate"> Time: 00:00, Date: 00/00/00</p>
                </div>
                <div class="activityBlock">
                    <h5 class="activityBanner"> TITLE </h5>
                    <p> Information about what happened </p>
                    <p class="activityDate"> Time: 00:00, Date: 00/00/00</p>
                </div>
            </div>
        
    
        
        <nav class="nav fixed-bottom">
            <a href="stats.php" class="nav-link btn" id="navBrowse"> PROGRESS </a>
            <a href="select_workout.php" class="nav-link" id="navTrain"> + </a>
            <a href="learn.php" class="nav-link btn" id="navInfo"> LEARN </a>
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

            $("#navBrowse").animate({top: '100px'}, 300);
          
            $("#navInfo").stop().delay(200).animate({top: '100px'}, 300);
              
            $("#navTrain").stop().delay(400).animate({top: '100px'}, 300);
           
        });
      
     
    </script>
    
 
  </body>
</html>