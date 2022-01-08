<?php
    require "db.php";
    $id = $_GET['planID'];
    $sql = "delete from partner where planID = '$id'";
    deleteFun($connect,$sql);
    $sql = "delete from plan where planID = '$id'";
    if(deleteFun($connect,$sql)){
        echo "<script>alert('Delete Success');window.location.href='./plan.php'</script>";
        exit();
    }else{
        var_dump(mysqli_error($connect));
        exit();
        // echo "<script>alert('Delete Fail');window.location.href='./plan.php'</script>";
        // exit();
    }
?>