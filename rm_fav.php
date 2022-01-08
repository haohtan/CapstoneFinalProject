<?php
$server = "db.luddy.indiana.edu";
$username = "i494f20_team41";
$password = "my+sql=i494f20_team41";
$dbname = "i494f20_team41";
$conn = mysqli_connect($server, $username, $password, $dbname);
if(!$conn){
    die("connection failed: ".mysqli_connect_error(). "<br>");
}
/*remove unlike tag*/
if(isset($_POST['unlikedtag'])){
    $tagid = $_POST['tagid'];
    $userid = $_POST['userid'];

    mysqli_query($conn,"DELETE FROM favorite WHERE tagID='$tagid' AND userID='$userid'");
    exit();
}

/*remove unlike post*/
if(isset($_POST['unlikedpost'])){
    $postid = $_POST['postid'];
    $userid = $_POST['userid'];


    mysqli_query($conn,"DELETE FROM favorite WHERE postID='$postid' AND userID='$userid'");
    exit();
}
?>
