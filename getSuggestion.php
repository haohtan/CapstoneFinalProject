<?php
    require "db.php";
    $destinationId = $_POST['destinationId'];
    $destinationId1 = $destinationId + 18;
    $sql = "select * from tag  where tagID > '$destinationId' and tagID <= '$destinationId1' and type = '1'";
    $res = selectFun($connect,$sql);
    echo json_encode(array("res"=>$res));
?>