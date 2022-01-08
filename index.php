<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <!--<meta http-equiv="x-ua-compatible" content="ie=edge">-->
        <meta name="google-signin-client_id" content="40069760996-m7meg75slq4mhd9kd5hc4lklva6fq2co.apps.googleusercontent.com">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Style CSS -->
        <link rel="stylesheet" href="css/style.css">

        <link rel="stylesheet" href="css/navFooter.css">
        <script src="https://apis.google.com/js/platform.js?hl=en" async defer></script>
        <!--search-part-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&family=Brygada+1918:wght@600&family=Cabin+Sketch:wght@700&display=swap" rel="stylesheet">
        <!--scroll to top-->
        <link rel="stylesheet" href="css/scroll_top.css">
        <!-- search & location_reco-->
        <link rel="stylesheet" href="css/homepage.css">

        <title>Trahoo Home</title>

    </head>
    <body style = "background-color: honeydew;">
        <?php require "loginDetector.php";?>

        <?php require "header.php";?>

        <!--scroll up-->
        <button onclick="topFunction()" id="myBtn"><i class="fas fa-angle-double-up"></i></button>

        <!-- <center body> -->
        <!--searching-->
        <div class="search-part">
            <div class="slogan">
                <i>So Many Ways To Play!</i>
            </div>
            <div class="search-box">
                <form action="searchbar.php" method="POST">
                    <div class="search-type">
                        <b> Search Type: </b>
                        <input type="radio" name="match_type" value="location" checked /> Location   <i class="fas fa-map-marker-alt"></i>
                        <input type="radio" name="match_type" value="user"/> User <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="instant-search">
                        <div class="input-container">
                            <input type="search" name="search_text" id="search_text" placeholder="Type to Search" class="search-txt" autocomplete="off" required/>
                            <button class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                </form>

                <div class="result-container">
                    <div class="search-result" id="result"></div>
                </div>
            </div>
        </div>
        </div>
        <!--Reco -->
        <!--location_reco-->
        <?php require_once('reco-location.php');?>
        <div class="reco">
            <div class="location_reco">
                <div class="location_reco_title">
                    <b><i> --  HOT LOCATIONS  -- </i></b>
                </div>
                <div class="all_reco_location">
                    <?php foreach ($row as $num => $info) { ?>
                        <div class="reco_location_each">
                            <div class="location_img">
                                <img src="<?= $info['tag_img'] ?>" width="280px" height="180px" style="border-radius:10px"/>
                            </div>
                            <div class="fav_btn">
                                <!--<div class="heart"></div>-->
                                <?php $tagid = $info['tagID']; ?>
                                <?php require_once('add_to_fav.php');?>
                                <?php $userid = $_SESSION['userID'];?>

                                <?php
                                $result1 = mysqli_query($conn,"SELECT * FROM favorite WHERE userID=$userid AND tagID=$tagid");
                                ?>
                                <?php if(mysqli_num_rows($result1) == 1){ ?>
                                    <!--user already liked this tag-->
                                    <span><a href="" class="unlike" id1="<?php echo $tagid; ?>" id2="<?php echo $userid; ?>"><i class="fas fa-heart" style="color:red;font-size: 30px;"></i></a></span>
                                <?php } else { ?>
                                    <!--user has not yet liked tag-->
                                    <span><a href="" class="like" id1="<?php echo $tagid; ?>" id2="<?php echo $userid; ?>"><i class="far fa-heart" style="color:red;font-size: 30px;"></i></a></span>
                                <?php } ?>
                            </div>

                            <div class="location_content">
                                <!--=$num+1*/-->
                                <b><?= $info['content'] ?></b>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php require_once "footer.php";?>

        <script src="js/scroll_top.js"></script>
        <script src="js/instant-search.js"></script>
        <script src="js/reco_location.js"></script>
        <script src="js/add_to_fav.js"></script>
        <script src="js/lockScreen.js">//For login feature</script>

    </body>
</html>