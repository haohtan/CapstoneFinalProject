<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="x-ua-compatible" content="ie=edge">-->
    <meta name="google-signin-client_id" content="40069760996-m7meg75slq4mhd9kd5hc4lklva6fq2co.apps.googleusercontent.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navFooter.css">
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" rel="stylesheet">
    <script src="https://apis.google.com/js/platform.js?hl=en" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

    <link rel="stylesheet" href="css/favorite.css">

    <!--google map api-->
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-qhXvdtD2w5dxG_CD8yp_OX_B06MYHGA&libraries=places&callback=initMap&sensor=false"></script>

    <title>Trahoo Favorite</title>

</head>
<body style = "background-color: honeydew;">
<?php require "loginDetector.php";?>
<?php require_once "header.php";?>

<?php require_once "favorite_bk.php";?>
<div class="fav_all">
    <!--fav_location-->
    <br/>
    <br/>
    <div class="fav_tag">
        <h2> -- Your Favorite Location -- </h2>
        <?php foreach ($fav_row_tag as $num1 => $fav_tag_info) {?>
            <?php if(($queryresult_fav_tag) >0){ ?>
                <div class="fav_tag_each">
                    <?php require_once('rm_fav.php');?>
                    <?php $tagid = $fav_tag_info['tagID']; ?>
                    <?php $userid = $_SESSION['userID'];?>
                    <div class="fav_tag_img" onclick="openModal('<?= $fav_tag_info['content'] ?>')">
                        <img src="<?= $fav_tag_info['tag_img'] ?>" width="280px" height="180px" style="border-radius:10px"/>
                    </div>
                    <span><a href="" class="unliketag" id1="<?php echo $tagid; ?>" id2="<?php echo $userid; ?>"><i class="fas fa-heart" style="color:red;font-size: 25px;position: absolute;top:8%;left:80%;"></i></a></span>
                    <div class="fav_tag_content" onclick="openModal('<?= $fav_tag_info['content'] ?>')"><b><?= $fav_tag_info['content'] ?></b>
                    </div>
                </div>
            <?php } else{ ?>
                <?php echo "You haven't add any location as favorite.";?>
            <?php } ?>

        <?php }?>
    </div>


    <!--google map info-->
    <div style="" id="modal" class="trahoo-modal-bg">
        <div class="trahoo-modal" style="">
            <div class="trahoo-modal-header">
                <div style="display:flex;align-items:center">
                    <h4 class="modal-title location"></h4>
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
                <button class="button" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <br/>
    <br/>



    <!--fav_post-->
    <div class="fav_post">
        <h2> -- Your Favorite Post -- </h2>

            <?php
                foreach ($fav_row_post as $row) {
                    if (count($queryresult_fav_post) > 0) {
                        $postID = $row['postID'];
                        $title = $row['title'];
                        $datetime = $row['datetime'];
                        $imagesJsonStr = $row['image'];
                        $imagesArr = json_decode($imagesJsonStr, 1);

                        if (count($imagesArr) != 0) {
                            foreach ($imagesArr as $k => $row) {
                                $imageStr = $row;
                                break;
                            }
                        }else{
                            $imageStr ="noMedia.jpg";
                        }

                        echo '
                        <div class="fav_post_each">
                            <a href="./viewpost.php?id=' . $postID . '" style="text-decoration:none;color:color:black">
                                <div class="fav_post_title">' . $title . '</div>
                                <div class="fav_post_dt"><a>' . $datetime . '</a></div>
                                <br/>
                                <img class="fav_post_img" src ="./imgs/'.$imageStr.'">
                            </a>  
                        </div>         
                        ';
                    } else {
                        echo "You haven't add any post as favorite.";
                    }
                }
            ?>

    </div>
</div>




<?php require_once "footer.php"; ?>

<script src="js/rm_fav.js"></script>
<script src="js/google_map_api.js">/</script>
<script src="js/lockScreen.js">//For login feature</script>

</body>
</html>