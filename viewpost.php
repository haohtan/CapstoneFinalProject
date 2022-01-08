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
require_once "./relationshipFunctions.php";
if(isset($_POST['follow'])){
    if($_POST['follow'] == "follow"){
        $postUserID = $_POST['postUserID'];
        createRelationship($userID,$postUserID);
    }
    if($_POST['follow'] == "unfollow"){
        $postUserID = $_POST['postUserID'];
        deleteRelationship($userID,$postUserID);
    }
    
}

$postID = $_GET['id'];

if (isset($_POST['submit'])) {
    
    $postID = $_POST['postID'];
    $content = $_POST['content'];
    $datetime = date("Y-m-d H:i:s");
    $sql = "insert into comment(`content`,`userID`,`datetime`,`postID`) values ('$content',$userID,'$datetime',$postID)";
    $res = insertFun($connect, $sql);
    if ($res) {
        echo "<script>alert('Comment Successfully!');window.location.href='./viewpost.php?id=".$postID."'</script>";
    } else {
        var_dump(mysqli_error($connect));
    }
}
?>
<?php
    $postID = $_GET['id'];
	$sql = "select * from `post` a join profile b on a.userID = b.userID where a.postID = '$postID'";
	$res = selectFun($connect, $sql);
	$resForTag = array();
	$resForComment = array();
	if(count($res) > 0){
		foreach ($res as $k => $row) {
			$postID = $row['postID'];
			$sql = "select b.tagID,b.content from `tag_post` a join `tag` b on a.tagID = b.tagID where a.`postID` = '$postID'";
			$resForTag = selectFun($connect, $sql);
			$res[$k]['tag'] = $resForTag;
			$sql = "select * from `comment` a join profile b on a.userID = b.userID where a.`postID` = '$postID'";
			$resForComment = selectFun($connect, $sql);
			$res[$k]['comment'] = $resForComment;
    }
}

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
    <script src="https://apis.google.com/js/platform.js?hl=en" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
	<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-qhXvdtD2w5dxG_CD8yp_OX_B06MYHGA&libraries=places&sensor=false">
</script>
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
        .carousel-inner video{
            width:100%
        }
        .tagButton{
            float:left;
            margin-left:8px;
            margin-top:8px
        }
        .tagButton:first-child{
            /* margin-left:0px */
        } 
        .button-trahoo{
            background:#00CED1;
            color:white
        }
		body{
			background-color: honeydew;
		}	
    </style>
</head>

<body style="margin-top:90px">
	<?php require "header.php"; ?>
    <div class="container" style="max-width:688px;">
    </br>
        <?php
        if (count($res) > 0) {
            foreach ($res as $row) {
                $postID = $row['postID'];
                $title = $row['title'];
                $datetime = $row['datetime'];
                $imagesJsonStr = $row['image'];
                $videoesJsonStr = $row['video'];
                $tagArr = $row['tag'];
                $commentArr = $row['comment'];
                $content = $row['content'];
                $firstN = $row['firstN'];
                $lastN = $row['lastN'];
                $avatar_url = $row['avatar_url'];   
                $tagStr = "";
                $postUserID = $row['userID'];
                // $sql = "select * from tag_post where `category` = 'post' and userID = '$postUserID' and postID = '$postID'";
                // $select 


                $followStyle = "";
                $unFollowStyle = "";
                $myFollowFlag = checkRelationship($userID,$postUserID);
                if($myFollowFlag){
                    $followStyle = 'display:none';
                }else{
                    $unFollowStyle = "display:none";
                }


                
                $hideDelete = "";
                $hideFollow = "";
                if($userID == $postUserID){
                     
                    $hideFollow = 'display:none';
                }else{
                    $hideDelete = "display:none";
                }   
                $commentStr = "";               
                $imagesStr = '';
                $imagesArr = array();
                $imagesArrCounter = 0;
                if ($imagesJsonStr != "") {
                    $imagesArr = json_decode($imagesJsonStr, 1);
                    $imagesArrCounter = count($imagesArr);
                    foreach ($imagesArr as $k => $row) {
                        if($k == 0){
                            $imagesStr = $imagesStr . '<div class="carousel-item active">
                            <img src="./imgs/' . $row . '">
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
                            <video style="height:100%;" src="./videoes/' . $row . '" controls>
                        </div>';
                    }
                }

                
                $mediaCounter = $imagesArrCounter + $videoesArrCounter;
                $number = 0;
                if ($imagesJsonStr == "" && $videoesJsonStr == "") {
                    $mediaStr = "";
                } else {
                    
                    
                    $mediaStr = '<div class="row">
                        <div class="col-lg-12">

                            <div id="demo-'.$postID.'" class="carousel slide" data-ride="carousel" style="height:500px">
            
                                
                                <input class="countNumber" type="hidden" value="'.$mediaCounter.'">
                             
                                <div class="carousel-inner"  style="height:500px">
                                    ' . $imagesStr . $ivideoesStr . '
                                </div>
                                <input class="counter" type="hidden" value="0">
                                <a class="carousel-control-prev">
                                    <img src="./imgs/left.png" width="30" height="30"/>
                                </a>
                                <a class="carousel-control-next">
                                    <img src="./imgs/right.png" width="30" height="30"/>
                                </a>
            
                            </div>
                        </div></div>';
                }


                if (count($tagArr) > 0) {
                    foreach ($tagArr as $rowTag) {
                        
                        $tagStr = $tagStr . '<button type="button" data-toggle="modal" data-target="#myModal" onclick="openModal('.$rowTag['tagID'].',\''.addslashes($rowTag['content']).'\')" class="button button-info tagButton">#' . $rowTag['content'] . '</button>';
                        
                        
                        
                    }
                } else {
                    $tagStr = "<span style='color:rgb(138,138,138)'>No tags ..</span>";
                }


                if (count($commentArr) > 0) {
                    foreach ($commentArr as $rowComment) {
                        $avatarUrlComment = $rowComment['avatar_url'];
                        
                        $commentStr = $commentStr . '<div style="display:flex;align-items:center">
                            <div>
                            <a href="./profile.php?target_userID='.$rowComment['userID'].'"><img src="'.$avatarUrlComment.'" class="" alt="" style="width:67px;height:60px;border-radius:50%"></a>
                            </div>
                            <div style="width:100%;padding-bottom:10px;margin-left:15px">
                                <div style="font-size:20px;display:flex;align-items:baseline;width:100%">
                                    <div style="font-weight:bold">'.$rowComment['firstN']." ".$rowComment['lastN'].'</div>
                                    <div class="" style="font-size:15px;color:rgb(138,138,138);margin-left:15px">' . $rowComment['datetime'] . '</div>
    
                                </div>
                                
                                
                            </div>
                            
                        </div><div style="margin-left:80px;padding-bottom:15px;border-bottom:1px solid rgba(0,0,0,.1);">' . $rowComment['content'] . '</div>';
                    }
                } else {
                    $commentStr = "<h5>No Comment ..</h5>";
                }
                echo '<div class="row" style="margin-top:5px;font-size:25px">
                        <div class="col-lg-12">
                            <h3 class="post-title">' . $title . '</h3>
                        </div>
            
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="display:flex;justify-content:space-between;align-items:center">
                            <div style="display:flex;align-items:flex-end">
                                <div>
                                <a href="./profile.php?target_userID='.$postUserID.'"><img src="'.$avatar_url.'" class="" alt="" style="width:70px;height:70px;border-radius:50%"></a>
                                </div>
                                <div style="font-size:19px;margin-left:15px">
                                    <h5>' . $firstN." ".$lastN . '</h5> <span class="color:rgb(188,188,188)">' . $datetime . '</span>
                                </div>
            
                            </div>
                            <div  style="'.$hideDelete.'">
                            <button  type="button" onclick="deletePost(this,'.$postID.')" class="button button-trahoo">Delete</button>
                               </div>
                               <div  style="'.$hideFollow.'">
                               <form action="" method="POST">
                               <input type="hidden" name="follow" value="follow">
                               <input type="hidden" name="postUserID" value="'.$postUserID.'">
                               <button style="'.$followStyle.'" class="button button-trahoo">Follow</button>
                               </form>
                               <form action="" method="POST">
                               <input type="hidden" name="follow" value="unfollow">
                               <input type="hidden" name="postUserID" value="'.$postUserID.'">
                               <button style="'.$unFollowStyle.'" class="button button-trahoo">UnFollow</button>
                               </form>
                               
                               </div>
                                
                                
                                
                             
            
                        </div>
                    </div>
                    
					</br>
                    ' . $mediaStr . '
					</br>
                    <div class="row">
                        <div class="col-lg-12" style="font-size:20px;margin-top:15px;margin-bottom:10px;">
                            <h3>'.str_replace("\n",'<br>',$content).'</h3>
                        </div>
            
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-lg-12" style="padding-left:7px;">
                            ' . $tagStr . '
                        </div>
                    </div>
            
                    <div class="row" style="margin-top:15px;margin-bottom:10px">
                        <div class="col-lg-12" style="display:flex;justify-content:space-between;align-items:center">
                            <i class="iconfont collect" style="font-size:32px" id="" onclick="collect(this,'.$postID.')"></i>
                        </div>
                    </div>
                    <div class="comment-'.$postID.'" style="">
                        <div class="row" style="margin-top:15px;margin-bottom:15px;">
                            <div class="col-lg-12">
                                
									</br>
                                    <div style="font-size:20px">
                                        <legend>Comment</legend>
                                    </div>
                                    <form action="" method="POST">
                                        <input type="hidden" name="postID" value="'.$postID.'">
                                        <textarea name="content" required class="commentTextarea form-style" id="" cols="10" rows="3" style="resize:none"></textarea>
                                        <div style="width:100%;text-align:right">
                                            <button class="button" style="margin-top:15px;background:#00CED1;color:white" name="submit">Submit</button>
                                        </div>
                                    </form>
                                    <hr>
                               
            
                            </div>
                        </div>						
                        <div class="row">
                            <div class="col-lg-12">
                                ' . $commentStr . '
                                
                            </div>
                        </div>
                    </div><hr>';
            }
        } else {
            echo "<h3>No Post Information ..</h3>";
        }
        ?>

    </div>
	<div style="" id="modal" class="trahoo-modal-bg">
        <div class="trahoo-modal" style="">
            <div class="trahoo-modal-header">
            <div style="display:flex;align-items:center">
                    <h4 class="modal-title location"></h4>
                    <i class="iconfont collectForTag" style="font-size:32px;margin-left:15px" id="" onclick="collectTag(this)"></i>
                </div>
            </div>
            <div class="trahoo-modal-body">
                <div class="row">
                        <div class="col-lg-5">
                                <table class="table table-hover">
                                    <tr>
                                    <td class="Rating"></td>
                                </tr>
                                <tr>
                                    <td class="Cost"></td>
                                </tr>
                                <tr>
                                    <td class="Address"></td>
                                </tr>
                                <tr>
                                    <td class="Hours"></td>
                                </tr>
                                </table>
                        </div>
                        <div class="col-lg-7">
                            <div id="map" style="width:500px;height:300px"></div>
                        </div>
                    </div>
            </div>
            <div class="trahoo-modal-footer" style="text-align:right;width:100%">
                <button class="button" type="button" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
		
	<?php require "footer.php"?>

    
    <script src="js/instant-search.js"></script>
	<script>
	
	 function openModal(tagID,tagContent){
        $("#modal").fadeIn(); 
        var tagContent1 = tagContent.replace(/\\'/g, "&acute;")
        $(".location").html(tagContent1);
        $(".Rating").html("");
        $(".Cost").html("");
        $(".Address").html("");
        $(".Hours").html("");
        var userIDPar = "<?php echo $userID;?>";
        var postIDPar = "<?php echo $postID;?>";
        tagIDPar = tagID;
        $.ajax({
            "url":"locationFavorite.php",
            "type":"POST",
            "data":{"action":"getFavourite","postIDPar":postIDPar,"userIDPar":userIDPar,"tagIDPar":tagIDPar},
            "dataType":"json",
            "success":function(res){
                if(res.state == "1"){
                    $(".collectForTag").addClass("icon-aixin");
                }else{
                    $(".collectForTag").addClass("icon-aixin1");
                }
            }
        }) 
        // 


        initMap(tagContent);
    }
    function closeModal(){
        $("#modal").fadeOut();
    }
    function initMap(tagContent) {
        if(google){
            var sydney = new google.maps.LatLng(-33.867, 151.195);

    map = new google.maps.Map(
      document.getElementById('map'), {center: sydney, zoom: 15});

	var findPlaceIdRequest = {
    query: tagContent,
	fields: ['place_id']
	};

	var service = new google.maps.places.PlacesService(map);
	service.findPlaceFromQuery(findPlaceIdRequest, function(results,status){
    console.log(results);
    
	var getPlaceDetailRequest = {
        placeId: results[0].place_id,
        fields: ['rating','price_level','geometry','formatted_address','opening_hours']
    };
    service.getDetails(getPlaceDetailRequest, function(results1,status1){
        map.setCenter(results1.geometry.location);
        var marker = new google.maps.Marker({
                            position: results1.geometry.location,
                            map: map,
                            title: tagContent
                        });
        
        console.log(results1);
        
        if(results1.rating){
            $(".Rating").html("Rating : "+results1.rating);
        }else{
            $(".Rating").html("No rating");
        }
		// 0 — Free
		// 1 — Inexpensive
		// 2 — Moderate
		// 3 — Expensive
		// 4 — Very Expensive
        if(results1.price_level){
			var str = "";
            if(results1.price_level == "0"){
                str = "Free";
            }
            if(results1.price_level == "1"){
                str = "$";
            }
            if(results1.price_level == "2"){
                str = "$$";
            }
            if(results1.price_level == "3"){
                str = "$$$";
            }
            if(results1.price_level == "4"){
                str = "$$$$";
            }
			
            $(".Cost").html("Price Level : "+str);
        }else{
            
			$(".Cost").html("No price level");
		}

        if(results1.formatted_address){
            $(".Address").html("Address : "+results1.formatted_address);
        }else{
            $(".Address").html("No address");
        }

        if(results1.opening_hours){
            console.log(results1.opening_hours)
            $(".Hours").html("Opening Hours : </br>"+results1.opening_hours.weekday_text.join(";<br>"));
        }else{
            $(".Hours").html("No opening hours");
        }
        console.log(results1.rating);
    })
  });
        }else{
            alert("Init google map fail !")
        }
}
	
	
    // collect js fav
    function getCollectState() {
        var userIDPar = "<?php echo $userID;?>";
        var postIDPar = "<?php echo $postID;?>";
        $.ajax({
            "url":"postFavorite.php",
            "type":"POST",
            "data":{"action":"getFavourite","postIDPar":postIDPar,"userIDPar":userIDPar},
            "dataType":"json",
            "success":function(res){
                if(res.state == "1"){
                    $(".collect").addClass("icon-aixin");
                }else{
                    $(".collect").addClass("icon-aixin1");
                }
            }
        })  
    }
	getCollectState();

    function collect(obj) {
        var userIDPar = "<?php echo $userID;?>";
        var postIDPar = "<?php echo $postID;?>";
        $.ajax({
            "url":"postFavorite.php",
            "type":"POST",
            "data":{"action":"collect","postIDPar":postIDPar,"userIDPar":userIDPar},
            "dataType":"json",
            "success":function(res){
                if(res.state == "1"){
                    $(obj).removeClass("icon-aixin");
                    $(obj).addClass("icon-aixin1");
                }

                if(res.state == "2"){
                    $(obj).removeClass("icon-aixin1");
                    $(obj).addClass("icon-aixin");
                    
                }
                
            }
        })  
    }


	 // collect tag js fav
    function collectTag(obj) {
        var userIDPar = "<?php echo $userID;?>";
        var postIDPar = "<?php echo $postID;?>";
        $.ajax({
            "url":"locationFavorite.php",
            "type":"POST",
            "data":{"action":"collect","postIDPar":postIDPar,"userIDPar":userIDPar,"tagIDPar":tagIDPar},
            "dataType":"json",
            "success":function(res){
                if(res.state == "1"){
                    $(obj).removeClass("icon-aixin");
                    $(obj).addClass("icon-aixin1");
                }

                if(res.state == "2"){
                    $(obj).removeClass("icon-aixin1");
                    $(obj).addClass("icon-aixin");
                    
                }
                
            }
        })
    }

    
    function commentbutton(obj,commentId) {
        $(obj).toggleClass("button-primary");
        $(obj).toggleClass("button-secondary");
        if ($(obj).hasClass("button-primary")) {
            $(obj).html("Show Comment");
            $("."+commentId).hide();
        } else {
            $(obj).html("Hide Comment");
            $("."+commentId).show();

        }
    }
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
            // alert("This is the first page");
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
            // alert("This is the last page");
        }
        
        // $(this).find("");
    })

    function EscapeChar(HaveSpecialval) {
            
            HaveSpecialval = HaveSpecialval.replace(/\'/g, "\\\'");

            
            HaveSpecialval = HaveSpecialval.replace(/\'/g, "&acute;");
            return HaveSpecialval;
        }

    function deletePost(obj,postID){
        if(confirm('Are you sure to delete this post?')){
            window.location.href="./deletePost.php?id="+postID;
        }
    }
</script>

</body>

</html>



