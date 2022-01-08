<?php require "./db.php";?>
<?php
if(!isset($_SESSION["userID"])){
    // get url from current site
    
    header("Location: https://cgi.luddy.indiana.edu/~team41/team-41/index.php");
} else{
    
	$userID = $_SESSION["userID"];
}



if (isset($_POST['submit'])) {
    // get post information
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    $content = $_POST['content'];
    $imagesJson = "";
    $videoesJson = "";
    $tagContentValue = $_POST['tagContentValue'];
    $tagContentArr = json_decode($tagContentValue,1);
    $datetime = date("Y-m-d H:i:s",time());
    // var_dump($_FILES['videoes']);
    // exit();
    // get images
    if($_FILES['images']['name'][0] != ""){
        $imagesArr = array();
        foreach($_FILES['images']['name'] as $k=>$imagesRow){
            $temp = explode(".", $_FILES['images']['name'][$k]);
            $filetype = end($temp);
            $filename = rand(100,999) . time() .".".$filetype;
            move_uploaded_file($_FILES['images']['tmp_name'][$k], "./imgs/" . $filename);
            array_push($imagesArr,$filename);
        }
        $imagesJson = json_encode($imagesArr,JSON_UNESCAPED_UNICODE);
    }
    // get videoes
    if($_FILES['videoes']['name'][0] != ""){
        $videoesArr = array();
        foreach($_FILES['videoes']['name'] as $k=>$videoesRow){
            $temp = explode(".", $_FILES['videoes']["name"][$k]);
            $filetype = end($temp);
            $filename = rand(100,999) . time() .".".$filetype;
            move_uploaded_file($_FILES['videoes']["tmp_name"][$k], "./videoes/" . $filename);
            array_push($videoesArr,$filename);
        }
        $videoesJson = json_encode($videoesArr,JSON_UNESCAPED_UNICODE); 
    }
    // exit();
    // get tag
    // $tag = $_POST['tag'];
    // var_dump($_FILES);
    $sql = "insert into post(`Title`,`b_discription`,`content`,`costPerDay`,`image`,`video`,`clickNum`,`datetime`,`userID`) value ('$title','$description','$content','$cost','$imagesJson','$videoesJson',0,'$datetime','$userID')";
    if(insertFun($connect,$sql)){
        
        $id = mysqli_insert_id($connect);
        if(count($tagContentArr) > 0){
            foreach($tagContentArr as $row){
                $tagID = $row['id'];
                $sql = "insert into tag_post(`tagID`,`postID`) values ($tagID,$id)";
                insertFun($connect,$sql);
            }
        }
        
        // $sql = "select * from post where postID = '$id'";
        // $res = selectFun($connect,$sql);
        // var_dump($res);
        // $sql = "select * from tag_post where postID = '$id'";
        // $res = selectFun($connect,$sql);
        // var_dump($res);

        header("Location:https://cgi.luddy.indiana.edu/~team41/team-41/community.php");
        exit();
        
    }else{
        echo mysqli_error($connect);
        exit();
    }
    
}
?>
