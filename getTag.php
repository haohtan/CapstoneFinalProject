<?php
    require "db.php";
    $tagValue = $_POST['tagValue'];
    $res = array();
    if($tagValue == ""){
        echo json_encode(array("res"=>array()));
    }
    $sql = "select * from `tag` where `content` like '%$tagValue%'";
    $res = selectFun($connect,$sql);
    echo json_encode(array("res"=>$res));
?>