<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="google-signin-client_id" content="40069760996-m7meg75slq4mhd9kd5hc4lklva6fq2co.apps.googleusercontent.com">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!--Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/navFooter.css">
    <script src="https://apis.google.com/js/platform.js?hl=en" async defer></script>
    <link rel="stylesheet" href="css/profile.css">

    <title>Trahoo Profile</title>

</head>

<body style = "background-color: honeydew;">
    <?php
    include('config.php');
    include('debug.php');
    if(!isset($_SESSION["userID"])){

        // get url from current site
        $_SESSION["current_url"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        echo "<div class = \"full-page-cover\"></div>";
        // Echo Google Login Box div
        echo "<div class = \"login-box\">";
        echo "<h2>Please Login First</h2>";
        echo "<p>Not a member? Sign up to join our community.";
        echo "<br>Membership is free (always).</p>";
        $goo = 'href=\''.$google_client->createAuthUrl().'\'';
        $login_button2 = '<div><button class="g-signin2" data-ux_mode="redirect" data-theme="light" onclick="window.location.'.$goo.'" ></button><p>Doesn\'t have Google account? Click <a href="https://accounts.google.com/signup/v2/webcreateaccount?hl=en&flowName=GlifWebSignIn&flowEntry=SignUp">here</a> to sign up.</p></div>';
        echo $login_button2;
        echo "</div>";}

    else{
        // grab user id if in the url
        include('profile-userInfo.php');
        if(!isset($_GET['target_userID'])){
            $displayID = $_SESSION["userID"];
            $user = new ProfileUser(); 
            $user->setID($displayID);
        }
        else{
            $displayID =$_GET['target_userID'];
            $user = new ProfileUser(); 
            $user->setID($displayID);
            include "relationshipFunctions.php";

    } 
    }
    ?>
    <?php require "header.php";?>
    <!-- <center body> -->
    <div class="cover-container container-margin ">
        <div class="cover">
            <div style="border-radius:inherit;height:inherit;background-color:rgba(255, 255, 255, 0); border-width:0;"><img src="<?PHP echo $user->getBackground();?>" class="profile-background" alt="background image"></div>
        </div>        
        
        <div class=" d-flex justify-content-center ">   
            <div class = "" style="background-color:rgba(255, 255, 255, 0); border-width:0;">
            <img class="avatar " src="<?php echo $user->getAvatar();?>" alt="avatar"></div>
        </div>

        <div class = "container user-info d-flex justify-content-center">
            <?php
            $diff = strtotime(date("Y-m-d")) - strtotime($user->getDOB()); // get date diff from today 
            $age = floor(abs($diff / 86400/365)); //get age 
            $gender = "";
            if ($user->getGender() == 1) $gender = "male";
            else if ($user->getGender() == 2) $gender = "female";
             //add gender class
            $output = '<div class="m-2"><p class = "'.$gender.' mt-2" style="text-align:center; font-weight:bold; font-size:25px; line-height:17px;">'.$user->getFull().'<br><span class="id" style="font-size:12px; font-weight:normal;"> Age: '.$age.' ID:'.$user->getID().'</span></p>';
            //check relationship createrelationship deleterelationship functions
            //include "relationshipFunctions.php";

            if (isset($_GET['target_userID'])){
                if (checkRelationship($_SESSION["userID"],$displayID)) $output .= '<form method="post" action=""><input type="hidden" id="custId" name="custId" value="'.$displayID.'"><button class="m-2 btn btn-trahoo btn-follow btn-unfollow" name="unfollow" style="position:relative; left:300px; top: -130px;">Unfollow</button></form></div>';else
                $output .= '<form method="post" action=""><input type="hidden" id="custId" name="custId" value="'.$displayID.'"><button class="m-2 btn btn-trahoo btn-follow " name="follow" style="position:relative; left:300px; top: -130px;">Follow</button></form></div>';
            }
            else{
                $output .= '<button class="m-2 btn btn-trahoo btn-follow "  onclick="launchModal(\'editInfo-modal\', \'editInfo-body\')" style="position:relative; left:300px; top: -130px;">Edit Profile</button></div>';
            }
            echo $output;
            ?>
        </div>
        <!--contact information and birthday-->
        <div id ="contactLinks" class = "d-flex justify-content-center" style="position:relative; top:-145px;">
            <p class="me-5 ms-5"><i class="bi bi-telephone"></i> <?php echo "<a href=\"tel:".$user->getPhone()."\">".$user->getPhone()."</a>"?>
            </p>
            <p class="me-5 ms-5">
                <i class="bi bi-egg"></i> <?php echo $user->getDOB();?>
            </p>
            <p class="me-5 ms-5"><i class="bi bi-envelope"></i> <?php echo "<a href=\"mailto:".$user->getEmail()."\">".$user->getEmail()."</a>"?></p>
        </div>

        <div id ="followButtons" class = "container follower-following d-flex justify-content-center" style ="border-top:3px solid rgba(153, 153, 153, 0.473); position:relative; top:-160px;">
            <button onclick="launchModal('viewFollowers', 'viewFollowers-body')"  class ="me-5 mt-4 btn btn-trahoo btn-follow followers-following-position">Followers</button>
            <button onclick="launchModal('viewFollowing','viewFollowing-body')" class ="ms-5 mt-4 btn btn-trahoo btn-follow followers-following-position">Following</button>
        </div>
        <?php 
        $printSign = '<div id="userSign" class = "d-flex justify-content-center"><pre  class = "personal-description">'.$user->getSign().' </pre>';

        if($user->getSign()) echo $printSign;        
        ?>
        </div>
        
        <?php
        $res = $user->getMyPosts();
        if (count($res) > 0){
            $myPostOutput = "            </section>
            </div>";
            foreach($res as $row){
                $title = $row['title'];
                $datetime = $row['datetime'];
                $imagesJsonStr = $row['image'];
                $b_discription = $row['b_discription']; 
                $imagesArr = json_decode($imagesJsonStr, 1);
                $postID = $row['postID'];

                if(count($imagesArr) != 0){
                    foreach ($imagesArr as $k => $row) {
                        $imageStr = $row;
                        break;
                    }
                }else{
                    $imageStr = "noMedia.jpg";
                }

                $myPostOutput = "
                    <div class = \"card\">
                        <a href=\"./viewpost.php?id=".$postID."\"><img class=\"card-img\" src =\"./imgs/".$imageStr."\" alt = \"xxs\" ></a>
                        <div >
                            <h2>".$title."</h2>
                            <p class = \"card-des\">".$b_discription."</p>
                            <p class = \"card-time\">".$datetime."</p>
                        </div>
                    </div>    ".$myPostOutput;

            }
            $myPostOutput = "<div id = \"my-posts\" class=\"container\">
            <h2 class=\"posts-title\">My Post</h2>
            <section class = \"container cards-container\">".$myPostOutput;
            echo $myPostOutput;
        }
            

        ?>
    </div>
        
    <!--Edit profile info-->
    <!-- Modal edit personal information-->
    <div id="editInfo-modal" class = "modal">
        <div class = "full-page-cover"></div>
        <div id="editInfo-body" class = "modal-body">
            <form class = "modal-form" action="" method="post" enctype="multipart/form-data">

                <div class = "modal-content">
                    <div class = "modal-header">
                        <div class = "close-button-container">
                            <button type="button" class = "close-button" onclick="closeModal('editInfo-modal', 'editInfo-body')">&#10006;</button>
                        </div>
                        <h2 style="margin-left:20px;color:white;">Edit Your Profile!</h2>
                    </div>

                    <div class = "modal-center">
                        <!--Names-->
                        <div class = "input-container">
                            <h2>Name:</h2>
                            <label class="input-group-text">First:</label>
                            <input name="first-name" value='<?php echo $user->getFirst();?>' type="text" aria-label="First name" class="input-name form-control">
                            <label class="input-group-text">Middle:</label>
                            <input name="middle-name" value='<?php echo $user->getMiddle();?>' type="text" aria-label="Middle name" class="input-name form-control">
                            <label class="input-group-text">Last:</label>
                            <input name="last-name" value='<?php echo $user->getLast();?>' type="text" aria-label="Last name" class="input-name form-control">                               
                        </div>

                        <!--Birthday-->
                        <div class="input-container birthday-container">
                            <span><strong>Date of Birth:  </strong></span>
                            <input name="birthday" type="date"  value='<?php echo $user->getDOB();?>'min='1899-01-01' max='2020-12-31' class="form-control" style="position: relative;left:40px;">
                        </div>
                    
                        <!--Gener-->
                        <div class="input-container gender-container d-flex">
                            <span><strong>Gender:  </strong></span>
                            <select name="gender-new" class="form-control" style="margin-left: 40px; width:200px;" required>
                                <?php
                                $genderOptions = "";
                                $genderList = array("Other","Male","Female");
                                for ($i = 0;$i < 3; $i++){
                                    if ($user->getGender() == $i) $genderOptions .= "<option value=".$i." selected>".$genderList[$i]."</option>";
                                    else $genderOptions .= "<option value=".$i.">".$genderList[$i]."</option>";
                                }
                                echo $genderOptions;
                                ?>
                            </select>
                        </div>

                        <!--Phone number-->                
                        <div class="input-container phone-container">
                            <span><strong>Phone Number:  </strong></span>
                            <input type="tel" id="phone" value="<?php echo $user->getPhone();?>" name="phone-new" class="form-control" style="width:60%;text-align: center;"placeholder="123-456-6789" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" >
                        </div>

                        <!--Privacy Setting-->
                        <div class="input-container privacy-container">
                            <span><strong>Privacy Setting:  </strong></span>
                            <select name="privacy-new" class="form-control" id="inputGroupSelect01" >
                            <?php
                                $privacyOptions = "";
                                $privacyList = array("Private","Public","Followers Only");
                                for ($i = 0;$i < 3; $i++){
                                    if ($user->getPrivacy() == $i) $privacyOptions .= "<option value=".$i." selected>".$privacyList[$i]."</option>";
                                    else $privacyOptions .= "<option value=".$i.">".$privacyList[$i]."</option>";
                                }
                                echo $privacyOptions;
                                ?>
                            </select>
                        </div>
                        <!--Description-->
                        <div class="input-container description-container">
                            <span><strong>Description:  </strong></span>
                            <textarea name="description-new"  class="form-control" aria-label="With textarea"><?php echo $user->getSign();?></textarea>
                        </div>

                        <div class="input-container file-container">
                            <h2>Files Upload</h2>
                            <label class="" id="inputGroup-sizing-default">Background:</label>
                            <input  name="background-image" type="file"  accept="image/*"  class="form-control" style="position:relative; left:191px;">
                            <br><label class="" id="inputGroup-sizing-default">Avatar:</label>
                            <input name="avatar-image" type="file" accept="image/*"  class="form-control" style="position:relative; left:232px;"> 
                            <br><label class="" id="inputGroup-sizing-default">Update your Verification:</label>
                            <input name="verification-new" accept="image/*"  type="file" class="form-control" >
                        </div>
                    </div>

                    

                    <div class = "modal-footer">
                        <div class= "footer-buttons">
                            <button type="button" class="button cancel-button" onclick="closeModal('editInfo-modal', 'editInfo-body')">Cancel</button>
                            <button type="submit" name="submit" class="button submit-button">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Modal view followers-->
    <div id="viewFollowers" class = "modal" >
        <div class = "full-page-cover"></div>
        <div id="viewFollowers-body" class = "modal-body" style = "height:400px;">
                <div class = "modal-content" style = "height:400px;">
                    <div class = "modal-header">
                        <div class = "close-button-container">
                            <button type="button" class = "close-button" onclick="closeModal('viewFollowers', 'viewFollowers-body')">&#10006;</button>
                        </div>
                        <h2 style="margin-left:20px;color:white;"><?php echo $user->getFirst();?>'s Followers</h2>
                    </div>

                    <div class = "modal-center" style="display:block;">
                        <?php 
                        require_once "relationshipFunctions.php";
                        include "launchFollows.php";
                        launchFollows($_SESSION["userID"], 0);
                        

                        ?>


                    </div>
                    <div class = "modal-footer">
                        <div class= "footer-buttons">
                            <button type="button" class="button cancel-button" onclick="closeModal('viewFollowers', 'viewFollowers-body')">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Modal view followers-->
    <div id="viewFollowing" class = "modal" >
        <div class = "full-page-cover"></div>
        <div id="viewFollowing-body" class = "modal-body" style = "height:400px;">
                <div class = "modal-content" style = "height:400px;">
                    <div class = "modal-header">
                        <div class = "close-button-container">
                            <button type="button" class = "close-button" onclick="closeModal('viewFollowing', 'viewFollowing-body')">&#10006;</button>
                        </div>
                        <h2 style="margin-left:20px;color:white;"><?php echo $user->getFirst();?>'s Following</h2>
                    </div>

                    <div class = "modal-center" style="display:block;">
                        <?php 
                        require_once "relationshipFunctions.php";
                       // include "launchFollows.php";
                        launchFollows($_SESSION["userID"], 1);
                        

                        ?>


                    </div>
                    <div class = "modal-footer">
                        <div class= "footer-buttons">
                            <button type="button" class="button cancel-button" onclick="closeModal('viewFollowing', 'viewFollowing-body')">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer --> 
    <?php require "footer.php"?>


    <script src="js/modalController.js"></script>

</body>

</html>
<?php 
// Edit profile save button clicked
if(isset($_POST["submit"])) {
    $userNewAvatar = file_get_contents($_FILES['avatar-image']['tmp_name']);    
    $userNewBackground = file_get_contents($_FILES['background-image']['tmp_name']);
    $userNewFirst = $_POST['first-name'];
    $userNewMiddle = $_POST['middle-name'];
    $userNewLast = $_POST['last-name'];
    $userNewPrivacy = $_POST['privacy-new'];debug_to_console($userNewPrivacy);
    $userNewSign = $_POST['description-new'];
    $userNewPhonenum = $_POST['phone-new'];
    $userNewDOB = $_POST['birthday'];
    $userNewverification = file_get_contents($_FILES['verification-new']['tmp_name']);
    $userNewGender = $_POST['gender-new'];debug_to_console($userNewGender);

    if (!empty($userNewAvatar) && getimagesize($_FILES['avatar-image']['tmp_name'])) $user->setAvatar($userNewAvatar);
    if (!empty($userNewBackground) && getimagesize($_FILES['background-image']['tmp_name'])) $user->setBackground($userNewBackground);
    if (!empty($userNewverification) && getimagesize($_FILES['verification-image']['tmp_name'])) $user->setVerification($userNewverification);

    if ($userNewverification)
    {
       // $img = imagecreatefromstring($content);
        //imagejpeg($img);
    } else {
        echo 'Image not found...!!!';debug_to_console('Image not found...!!!');
    }

    if (!empty($userNewFirst)) $user->setFirst($userNewFirst);
    if (!empty($userNewMiddle)) $user->setMiddle($userNewMiddle);
    if (!empty($userNewLast)) $user->setLast($userNewLast);
    $userNewFull = $user->getFirst()." ".$user->getMiddle()." ".$user->getLast();debug_to_console($userNewFull);

    if (!empty($userNewFirst) || !empty($userNewMiddle) || !empty($userNewLast) ) $user->setFull($userNewFull);
    if (/*!empty($userNewPrivacy) && when empty(0) return true;*/ is_numeric($userNewPrivacy)  ) $user->setPrivacy($userNewPrivacy);
    if (!empty($userNewSign)) $user->setSign($userNewSign);
    if (!empty($userNewPhonenum)) $user->setPhone($userNewPhonenum);
    if (!empty($userNewDOB)) $user->setDOB($userNewDOB);
    if (/*!empty($userNewGender) &&*/ is_numeric($userNewGender)) $user->setGender($userNewGender);
   // header("Location:http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",true,302);
    echo "<script language=JavaScript> location.replace(location.href);</script>";


}
    //Follow button clicked
    if(isset($_POST["follow"])) {
        if (!checkRelationship($_SESSION["userID"],$_POST["custId"]))
        createRelationship($_SESSION["userID"],$_POST["custId"]);
     //   header("Location:http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",true,302);
        echo "<script language=JavaScript> location.replace(location.href);</script>";
    }

    //Unfollow button clicked
    if(isset($_POST["unfollow"])) {
        if (checkRelationship($_SESSION["userID"],$_POST["custId"]))
        deleteRelationship($_SESSION["userID"],$_POST["custId"]);
    //    header("Location:http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",true,302);
        echo "<script language=JavaScript> location.replace(location.href);</script>";


    }

?>    
<?php
if (($displayID != $_SESSION["userID"]) & (!displayProfile($_SESSION["userID"],$displayID,$user->getPrivacy()))) echo "<script src=\"js/profileHidden.js\"language=JavaScript></script>"; 

?>