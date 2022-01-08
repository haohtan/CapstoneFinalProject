<?php
$server = "db.luddy.indiana.edu";
$username = "i494f20_team41";
$password = "my+sql=i494f20_team41";
$dbname = "i494f20_team41";
$conn = mysqli_connect($server, $username, $password, $dbname);
if(!$conn){
    die("connection failed: ".mysqli_connect_error(). "<br>");
}

//location reco
$output = '';
$imgs = '';
$img_location = '';
$sql = "SELECT content, tag_img, tag.tagID AS tagID FROM tag
INNER JOIN tag_post ON tag.tagID = tag_post.tagID
GROUP BY content
ORDER BY count(*) DESC
LIMIT 16";
$result = mysqli_query($conn,$sql);
$queryresult = mysqli_num_rows($result);
if ($queryresult == 16){
    $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
}else{
    echo "something wrong";
}
/*echo $output;
echo $imgs;*/
mysqli_close($conn);
?>
