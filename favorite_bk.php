<?php
$server = "db.luddy.indiana.edu";
$username = "i494f20_team41";
$password = "my+sql=i494f20_team41";
$dbname = "i494f20_team41";
$conn = mysqli_connect($server, $username, $password, $dbname);
if(!$conn){
    die("connection failed: ".mysqli_connect_error(). "<br>");
}


$userid = $_SESSION['userID'];
$ept_tag_msg = '';
$ept_post_msg = '';

/*fav_location*/
$sql_fav_tag = "SELECT content, tag_img, tag.tagID AS tagID FROM tag
INNER JOIN favorite 
ON tag.tagID = favorite.tagID
WHERE favorite.userID= '$userid' AND favorite.category = 'location'
GROUP BY favorite.userID, tagID";

$result_fav_tag = mysqli_query($conn,$sql_fav_tag);
$queryresult_fav_tag = mysqli_num_rows($result_fav_tag);

if ($queryresult_fav_tag > 0){
    $fav_row_tag = mysqli_fetch_all($result_fav_tag,MYSQLI_ASSOC);
}else{
    $ept_tag_msg .= "You haven't add any location as favorite.";
}

/*fav_post*/
$sql_fav_post = "SELECT title, image, video, datetime, post.postID AS postID FROM post
INNER JOIN favorite ON post.postID = favorite.postID
WHERE favorite.userID= '$userid' AND favorite.category = 'post'
GROUP BY favorite.userID, postID";

$result_fav_post = mysqli_query($conn,$sql_fav_post);
$queryresult_fav_post = mysqli_num_rows($result_fav_post);
if ($queryresult_fav_post > 0){
    $fav_row_post = mysqli_fetch_all($result_fav_post,MYSQLI_ASSOC);
}else{
    $ept_post_msg .= "You haven't add any post as favorite.";
}


mysqli_close($conn);
?>