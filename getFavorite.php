<?php
    require "db.php";
    if(!isset($_SESSION["userID"])){
        // get url from current site
        
        //header("Location: https://cgi.luddy.indiana.edu/~team41/team-41/index.php");
    } else{
        
        $userID = $_SESSION["userID"];
        
    }
    $destinationId = $_POST['destinationId'];
    $key = $_POST['key'];
    $destinationId1 = $destinationId + 18;
    $sql = "select * from favorite a join tag b on a.tagID = b.tagID where a.userID = '$userID'  and b.tagID > '$destinationId' and b.tagID <= '$destinationId1' and b.content like '%$key%'";
    $res = selectFun($connect,$sql);
    echo json_encode(array("res"=>$res));
?>