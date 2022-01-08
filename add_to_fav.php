<?php
$server = "db.luddy.indiana.edu";
$username = "i494f20_team41";
$password = "my+sql=i494f20_team41";
$dbname = "i494f20_team41";
$conn = mysqli_connect($server, $username, $password, $dbname);
if(!$conn){
    die("connection failed: ".mysqli_connect_error(). "<br>");
}

if(isset($_POST['liked'])){
    $tagid = $_POST['tagid'];
    $userid = $_POST['userid'];
    /*$result = mysqli_query($conn,"SELECT * FROM favorite WHERE tagID=$tagid");
    $row = mysqli_num_rows($result);*/

    mysqli_query($conn,"INSERT INTO favorite(category,tagID, userID, status) VALUES('location','$tagid','$userid',1)");
    exit();
}
if(isset($_POST['unliked'])){
    $tagid = $_POST['tagid'];
    $userid = $_POST['userid'];
    /*$result = mysqli_query($conn,"SELECT * FROM favorite WHERE tagID=$tagid");
    $row = mysqli_num_rows($result);*/

    mysqli_query($conn,"DELETE FROM favorite WHERE tagID='$tagid' AND userID='$userid'");
    exit();
}
?>

<!--mysqli_close($conn);-->

<!--$data['userId'] = $_SESSION['userId'];

$data['pid'] = $pid;

$collect_pic = M('collect')->where($data)->getfield('status');

$this->collect_num = $collect_num;

$this->collect_pic = $collect_pic;


public function add_to_fav(){
$data['pid'] = isset($_POST['id'])?intval(trim($_POST['id'])):1;

$data['uid'] = $_SESSION['uid'];

//1-fav 0-rm fav

$status = isset($_POST['status'])?intval(trim($_POST['status'])):1;

$db = M('collect');

if($status == 1){
//

if(M('collect') ->data($collect)->add()){
$msg['info'] = "ok";

$msg['status'] = 0;

/*$this->ajaxreturn($msg);*/

exit;

}else{
$msg['info'] = 'fail';

$msg['status'] = 0;

/* $this->ajaxreturn($msg);*/

}

}else{
//cencel fav

if($db->where($data)->delete()){
$msg['info'] = "ok";

$msg['status'] = 1;

/*  $this->ajaxreturn($msg);*/

exit;

}else{
$msg['info'] = 'fail';

$msg['status'] = 1;

/* $this->ajaxreturn($msg);*/

}

}-->
