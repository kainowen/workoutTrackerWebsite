<?php

    include "logincheck.php";

    $exerciseRecord = $_SESSION['id']."exerciserecord";

    $link = mysqli_connect("shareddb-s.hosting.stackcp.net", "myusers-3132359bf0", "SAb.DCIPW}'c", "myusers-3132359bf0");

    if (!$link) {
           
        die('Connect Error: ' . mysqli_connect_error());
    }

        $query = 'SELECT id 
                  FROM exerciselibrary 
                   WHERE exercisename = "'.$_GET['exercise'].'"';

        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
 
        $exerciseId = $row['id'];

        $query = "SELECT weight, reps, datecreated
                    FROM ".$exerciseRecord."
                    WHERE exerciseid = '".$exerciseId."'
                    LIMIT 20";
        
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
 
$i =0;
$data =[];
foreach ($result as $key => $value){
array_push($data, $value);
$i++;
}
$data = json_encode($data);
print_r($data);

?>