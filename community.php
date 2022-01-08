<?php require "loginDetector.php"?>

<?php 
	// connection 
    $connect = mysqli_connect("db.luddy.indiana.edu", "i494f20_team41", "my+sql=i494f20_team41", "i494f20_team41");
    
    // get data
    function selectFun($connect,$sql){
            
        $query = mysqli_query($connect,$sql);
            $res = mysqli_fetch_all($query,1);
            if($query){
                return $res;
            }else{
                return false;
            }
    }
    // update data
    function updateFun($connect,$sql){
        
            $query = mysqli_query($connect,$sql);
            $num = mysqli_affected_rows($connect);
            if($num > 0){
                return true;
            }else{
                return false;
            }
    }
    // insert data 
    function insertFun($connect,$sql){
            $query = mysqli_query($connect,$sql);
            $num = mysqli_affected_rows($connect);
            if($num > 0){
                return true;
            }else{
                return false;
            }
    }
    // delete data
    function deleteFun($connect,$sql){
        $query = mysqli_query($connect,$sql);
        $num = mysqli_affected_rows($connect);
        if($num > 0){
            return true;
        }else{
            return false;
        }
    }

?>

<?php
    $filter = "";
    
    if (isset($_POST['filter'])) {
        $filter = $_POST['filter'];
        if($filter == 'Latest'){
            $sql = "select * from `post` a join profile b on a.userID = b.userID order by a.datetime desc";
        }
        if($filter == 'MostPopular'){
            $sql = "select * from `post` a join profile b on a.userID = b.userID order by a.clickNum desc";
        }
        if($filter == 'CostLowtoHigh'){
            $sql = "select * from `post` a join profile b on a.userID = b.userID order by a.costPerDay asc";
        }
        if($filter == 'CostHightoLow'){
            $sql = "select * from `post` a join profile b on a.userID = b.userID order by a.costPerDay desc";
        }
        if($filter == 'Following'){
            $sql = "select * from `post` a join relationship b on a.userID = b.userBID where b.userAID = '$userID' order by a.datetime desc";
        }
        if($filter == 'Myself'){
            $sql = "select * from `post` a join profile b on a.userID = b.userID where a.userID = '$userID'";
        }
    }else{
        $sql = "select * from `post` a join profile b on a.userID = b.userID order by a.datetime desc";
    }

	if (isset($_GET['tagID'])) {
        $tagID = $_GET['tagID'];
        $sql = "select distinct * from `post` a join profile b on a.userID = b.userID join tag_post c on a.postID = c.postID where c.tagID = '$tagID' order by a.datetime desc";
    }
	$res = selectFun($connect, $sql);
	



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="google-signin-client_id" content="40069760996-m7meg75slq4mhd9kd5hc4lklva6fq2co.apps.googleusercontent.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trahoo</title>

	<link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://at.alicdn.com/t/font_2368594_si67l606g1r.css">
	<link rel="stylesheet" href="css/navFooter.css">
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <script src="https://apis.google.com/js/platform.js?hl=en" async defer></script>
    <!--scroll to top-->
    <link rel="stylesheet" href="css/scroll_top.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

    <style>
        .icon-aixin {
            color: red
        }

        .iconfont {
            cursor: pointer
        }
        .carousel-inner img{
            width:100%
        }
        
        .tagButton{
            margin-left:15px;
            margin-top:8px
        }
        .tagButton:first-child{
            margin-left:0px
        } 
        .button-trahoo{
            background:#00CED1;
            color:white
        }
        img{
            object-fit: contain;
        }
		body{
			background-color: honeydew;
		}

    </style>
</head>

<body style="margin-top:138px;">
    <!--scroll up-->
    <button onclick="topFunction()" id="myBtn"><i class="fas fa-angle-double-up"></i></button>
    <script src="js/scroll_top.js"></script>

	<?php require "header.php"; ?>
    <div class="container" style="position:relative">
    <div class="row" style="display:flex;justify-content:space-between;padding-left:50px;padding-right:50px">
        <div class="col-md-4" style="">
            <form action="" method="POST" id="form">
                <select name="filter" id="" class="form-style" onchange="submit()">
                    <option <?php if($filter == 'Latest'){echo "selected";}?> value="Latest">Latest</option>
                    <option <?php if($filter == 'MostPopular'){echo "selected";}?> value="MostPopular">Most-Popular</option>
                    <option <?php if($filter == 'CostLowtoHigh'){echo "selected";}?> value="CostLowtoHigh">Cost:Low to High</option>
                    <option <?php if($filter == 'CostHightoLow'){echo "selected";}?> value="CostHightoLow">Cost:High to Low</option>
                    <option <?php if($filter == 'Following'){echo "selected";}?> value="Following">Following</option>
                    <option <?php if($filter == 'Myself'){echo "selected";}?> value="Myself">Myself</option>
                </select>
            </form>
        </div>
        <div class="col-md-6" style="position:relative;text-align:right">
        <button class="button" onclick="javacript:window.location.href='./createPostFromUser.php'">Create</button>
        </div>
    </div>
    
    </br>
        <?php
        if (count($res) > 0) {
            echo '<div class="row" style="position:relative;top:-30px">';
            foreach ($res as $row) {
                $postID = $row['postID'];
                $title = $row['title'];
                $datetime = $row['datetime'];
                $imagesJsonStr = $row['image'];
                $videoesJsonStr = $row['video'];
                $content = $row['content'];
                $firstN = $row['firstN'];
                $lastN = $row['lastN'];
                $avatar_url = $row['avatar_url']; 
                $b_discription = $row['b_discription']; 
                               
                $imagesStr = '';
                $imagesArr = array();
                $imagesArrCounter = 0;
                if ($imagesJsonStr != "") {
                    $imagesArr = json_decode($imagesJsonStr, 1);
                    $imagesArrCounter = count($imagesArr);
                    foreach ($imagesArr as $k => $row) {
                        if($k == 0){
                            $imagesStr = $imagesStr . '<div class="carousel-item active">
                            <img style="background: rgb(173 225 226);" src="./imgs/' . $row . '">
                        </div>';
                        }else{
                            $imagesStr = $imagesStr . '<div class="carousel-item">
                            <img src="./imgs/' . $row . '">
                        </div>';
                        }
                        
                    }
                }
                
                $ivideoesStr = '';
                $videoesArr = array();
                $videoesArrCounter = 0;
                if ($videoesJsonStr != "") {
                    $videoesArr = json_decode($videoesJsonStr, 1);
                    $videoesArrCounter = count($videoesArr);
                    foreach ($videoesArr as $row) {
                        
                        $ivideoesStr = $ivideoesStr . '<div class="carousel-item">
                            <video src="./videoes/' . $row . '" controls>
                        </div>';
                    }
                }
                
                $mediaStr = "";
                $mediaIndicators = "";
                $mediaCounter = $imagesArrCounter + $videoesArrCounter;
                
                if ($imagesJsonStr == "" && $videoesJsonStr == "") {
                    $mediaStr = '<div class="row" style="height:300px;line-height:300px;text-align:center;font-size:38px"><div class="col-lg-12"><a href="./viewpost.php?id='.$postID.'"><img style="background: rgb(173 225 226);" src="./imgs/noMedia.jpg" width="100%" height=300></a></div></div>';
                } else {
                    
                    
                    $mediaStr = '<div class="row">
                        <div class="col-lg-12" style="background-color: Ivory;">

                            <div id="demo-'.$postID.'" class="carousel slide" data-ride="carousel">            
                                
                                <input class="countNumber" type="hidden" value="'.$mediaCounter.'">
                                <a href="./viewpost.php?id='.$postID.'">
                                <div class="carousel-inner">
                                    ' . $imagesStr . $ivideoesStr . '
                                </div>
                                </a>
                                <input class="counter" type="hidden" value="0">
					
                                
            
                            </div>
                        </div></div>';
                }

                
                echo '<div class="col-lg-5  trahoo-card" style="margin-top:60px;margin-left:60px;background-color:Ivory;">
                            
                       
                ' . $mediaStr . '
					</br>
                    <div class="row" style="background-color: Ivory;">
                        <div class="col-lg-12" style="margin-bottom:15px;">
                        <a href="./viewpost.php?id='.$postID.'" style="text-decoration:none;color:color:black">
                            <div class="post-title" style="font-size:26px;color:rgb(38,38,38);text-overflow:ellipsis;">'.$title.'</div>
                            </a>
                        </div>
                        <div class="col-lg-12" style="margin-bottom:15px;font-weight:bold;">
                            <label>Brief description</label>
                        </div>
                        <a href="./viewpost.php?id='.$postID.'" style="text-decoration:none;color:#a5a4a9">
                        <div class="col-lg-12" style="margin-bottom:15px;">
                            <div style="height:80px;text-overflow:ellipsis;font-size:14px">'.$b_discription.'</div>
                        </div>
                        </a>
                        <div class="col-lg-12">
                        <h4 style="text-align:right">'.$datetime.'</h4>
                    </div>
                    </div>
                    
                    
            
                    
                    
                    ';
                   echo '</div>'; 
            }
        } else {
            echo "<h3>No Post Information ..</h3>";
        }
        ?>

    </div>
	</div>
		
	<?php require "footer.php"?>

	<script>
	
	 
    
    $(".carousel").each(function(item){
        $(this).find(".carousel-item").eq(0).fadeIn();
    })


    $(".carousel-control-prev").click(function(){
        var parent = $(this).parents(".carousel");
        var countNumber = parent.find(".countNumber");
        var counter = parent.find(".counter");
        var pageNumber = counter.val();
        console.log(pageNumber);
        if(pageNumber >= 1){
            pageNumber--;
            $(this).parents(".carousel").find(".counter").val(pageNumber);
            parent.find(".carousel-item").fadeOut();
            parent.find(".carousel-item").eq(pageNumber).fadeIn();
        }else{
            //alert("This is the first image");
        }
        
        // $(this).find("");
    })
    
    $(".carousel-control-next").click(function(){
        var parent = $(this).parents(".carousel");
        var countNumber = parent.find(".countNumber");
        var counter = parent.find(".counter");
        var pageNumber = counter.val();
        console.log(pageNumber);
        if(pageNumber < countNumber.val()-1){
            pageNumber++;
            $(this).parents(".carousel").find(".counter").val(pageNumber);
            console.log(pageNumber);
            console.log($(this).parents(".carousel").find(".counter").val())
            parent.find(".carousel-item").fadeOut();
            parent.find(".carousel-item").eq(pageNumber).fadeIn();
        }else{
            //dalert("This is the last image");
        }
        
        // $(this).find("");
    })
    function submit(){
        $("#form").submit();
    }
</script>

</body>

</html>



