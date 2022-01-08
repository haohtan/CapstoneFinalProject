<?php
    require "db.php";
    $id = $_GET['id'];
    $sql = "delete from comment where postID = '$id'";
        deleteFun($connect,$sql);
    $sql = "delete from favorite where postID = '$id'";
        deleteFun($connect,$sql);
    $sql = "delete from tag_post where postID = '$id'";
        deleteFun($connect,$sql);
    $sql = "delete from post where postID = '$id'";
    if(deleteFun($connect,$sql)){
        
        echo "<script>alert('Delete Success');window.location.href='./community.php'</script>";
        exit();
    }else{
        // echo "<script>alert('Delete Fail');window.location.href='./community.php'</script>";
        var_dump(mysqli_error($connect));
        exit();
    }
?>

