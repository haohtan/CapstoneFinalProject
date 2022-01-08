<?php
$server = "db.luddy.indiana.edu";
$username = "i494f20_team41";
$password = "my+sql=i494f20_team41";
$dbname = "i494f20_team41";
$conn = mysqli_connect($server, $username, $password, $dbname);
if(!$conn){
    die("connection failed: ".mysqli_connect_error(). "<br>");
}
if(isset($_POST['action'])){
    if($_POST['action']=="getFavourite"){
        $postID = $_POST['postIDPar'];
        $userID = $_POST['userIDPar'];
        
        $sql = "select * from favorite where `category` = 'post' and userID = '$userID' and postID = '$postID'";
        $query = mysqli_query($conn,$sql);
        $res = mysqli_fetch_all($query,1);
        if(count($res) > 0){
            echo json_encode(array("state"=>1));
        }else{
            echo json_encode(array("state"=>-1));
        }
    }

    if($_POST['action']=="collect"){
        $postID = $_POST['postIDPar'];
        $userID = $_POST['userIDPar'];
        $sql = "select * from favorite where `category` = 'post' and userID = '$userID' and postID = '$postID'";
        $query = mysqli_query($conn,$sql);
        $res = mysqli_fetch_all($query,1);
        if(count($res) > 0){
            $sql = "delete from favorite where `category` = 'post' and userID = '$userID' and postID = '$postID'";
            $query = mysqli_query($conn,$sql);
            if($query){
                echo json_encode(array("state"=>1));
            }else{
                echo json_encode(array("state"=>-1));
            }
        }else{
            $sql = "insert into favorite(`category`,`postID`,`userID`) values ('post','$postID','$userID')";
            $query = mysqli_query($conn,$sql);
            if($query){
                echo json_encode(array("state"=>2));
            }else{
                echo json_encode(array("state"=>-1));
            }
        }
    }
    
    // mysqli_query($conn,"INSERT INTO favorite(category,tagID, userID, status) VALUES('location','$tagid','$userid',1)");
    
}


// if(isset($_POST['type'])){
    
//     $tagid = $_POST['tagid'];
//     $userid = $_POST['userid'];
//     /*$result = mysqli_query($conn,"SELECT * FROM favorite WHERE tagID=$tagid");
//     $row = mysqli_num_rows($result);*/

//     mysqli_query($conn,"INSERT INTO favorite(category,tagID, userID, status) VALUES('location','$tagid','$userid',1)");
    
// }
// if(isset($_POST['type'])){
//     $tagid = $_POST['tagid'];
//     $userid = $_POST['userid'];
//     /*$result = mysqli_query($conn,"SELECT * FROM favorite WHERE tagID=$tagid");
//     $row = mysqli_num_rows($result);*/

//     mysqli_query($conn,"DELETE FROM favorite WHERE tagID='$tagid' AND userID='$userid'");
    
// }

?>

