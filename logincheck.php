<?php

    $userId = $_COOKIE['workoutTracker'];
    $email = $_SESSION['email'];

    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");

    if (!$link) {
           
        die('Connect Error: ' . mysqli_connect_error());
    }
    

    
    if (isset($_COOKIE['workoutTracker'])){

        $query = "SELECT id, email, Name
                    FROM myusers
                    WHERE id ='".$userId."'";
                  
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['Name'];
        
        if (array_key_exists('email', $row) && $row['Name'] !== ""){
                        
            $userName = $row['Name'];
            
        } else if (array_key_exists('email', $row) && $row['Name'] === ""){
                        
            $userName = $row['email'];
            
        } 
        
    }  else if (isset($_SESSION['email'])){
        
$query = "SELECT id
            FROM myusers
            WHERE email ='".$email."'";
                  
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        
        $userId = $row['id'];
        
    }else {
            
        header("Location: signup.php");
            
    }
    
    
    
    
    if (isset($_POST["logout"])){

        setcookie("workoutTracker", "", time()- 3600, "/");
        header("Location: signup.php");

    }

?>