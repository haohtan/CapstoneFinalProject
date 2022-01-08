<?php require_once "./db.php" ?>
<?php require "loginDetector.php";?>

<?php
    $planID = $_GET['planId'];
    $sql = "select * from partner a join plan b on a.planID = b.planID where a.planID = '$planID'";
    
    $myPlan = selectFun($connect,$sql);
    // age
    $myAge = $myPlan[0]['age'];
    // gender
    $myGender = $myPlan[0]['gender'];
    // num of people
    $myNum = $myPlan[0]['num_people'];
    // destination
    $myDestination = $myPlan[0]['destination'];
    // cost
    $myEstimated_price = $myPlan[0]['Estimated_price'];
    // start Date
    $myStartDate = $myPlan[0]['start_date'];
    $myMonth = date("m",strtotime($myStartDate." 00:00:00"));
    $genderArr = array();
    $genderArr[0] = "no Preference";
    $genderArr[1] = "Male";
    $genderArr[2] = "Female";
    $sqlAll = "select *,a.age as age,c.gender as gender,a.num_people as num_people,c.userID as userID from partner a join plan b on a.planID = b.planID join profile c on b.userID = c.userID where a.planID != '$planID' and b.userID != '$userID'";
    $allPlan = selectFun($connect,$sqlAll);
    $matchPartnerArr = array();
    foreach($allPlan as $row){
        $score = 0;
        // age
        $singleAge = $row['age'];
        // gender
        $singleGender = $genderArr[$row['gender']];
        // num of people
        $singleNum = $row['num_people'];
        // destination
        $singleDestination = $row['destination'];
        // cost
        $singleEstimated_price = $row['Estimated_price'];
        // start Date
        $singleStart_date = $row['start_date'];
        $singleMonth = date("m",strtotime($singleStart_date." 00:00:00"));

        if($singleDestination == $myDestination){
            $score = 50;
            if($singleAge == $myAge){
                $score = $score + 10 ;
            }
            if($singleGender == $myGender){
                $score = $score + 10 ;
            }
            if($myNum == $singleNum){
                $score = $score + 10 ;
            }
            if($myEstimated_price == $singleEstimated_price){
                $score = $score + 10 ;
            }
            if($myMonth == $singleMonth){
                $score = $score + 10 ;
            }
            $row['score'] = $score;
            array_push($matchPartnerArr,$row);
        }

        
    }
        $tempArr = array();
        foreach ($matchPartnerArr as $key=>$value){
            $tempArr[$key] = $value['score'];
        }
        array_multisort($tempArr,SORT_DESC,$matchPartnerArr);
    
    
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once "./header.php" ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="google-signin-client_id" content="40069760996-m7meg75slq4mhd9kd5hc4lklva6fq2co.apps.googleusercontent.com">
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Style CSS -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" rel="stylesheet">

    <!-- Style CSS -->
    <link rel="stylesheet" href="css/plan.css">   
     <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">

    <link rel="stylesheet" href="css/navFooter.css">
    <style>
        body{
        padding-top: 138px;
        margin: 0;
    }
    .copyright-area{
        width: 100%;

    }
    </style>
</head>
<body style = "background-color: honeydew;">
<form action="" method="POST">

    <div class="container">
        <h1>Match Result</h1>
        <hr />
        <div class="row">
            <?php
                if(count($matchPartnerArr) == 0){
                    echo '<div class="col-md-12">
                    <div class="trahoo-card">
                        <h3 style="text-align:center">No match result !</h3>
                    </div>
                </div>';
                }else{
                    foreach($matchPartnerArr as $k=>$matchPartnerRow){
                        
                        echo '<div class="col-md-12">
                        <div class="trahoo-card">
                            <div class="row">
                                <div class="col-md-1">
                                    <h1>'.($k + 1).'.</h1>
                                </div>
                                <div class="col-md-11">
                                    <div class="trahoo-card">
                                        <div class="row" style="display:flex;align-items:center;">
                                            <div class="col-md-2">
                                                <a href="./profile.php?target_userID='.$matchPartnerRow['userID'].'">
                                                    <div class="img-div">
                                                        <img height=80 width=80 src="'.$matchPartnerRow['avatar_url'].'"/>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                Full Name : '.$matchPartnerRow['firstN'].' '.$matchPartnerRow['middleN'].' '.$matchPartnerRow['lastN'].'
                                                <br>
                                                Gender: '.$genderArr[$matchPartnerRow['gender']].' 
                                                <br>
                                                Plan Name: '.$matchPartnerRow['plan_title'].' 
                                                <br> 
                                                Start Date: '.$matchPartnerRow['start_date'].' End Date: '.$matchPartnerRow['end_date'].'
                                            </div>
                                            <div class="col-md-1">
                                                Score: '.$matchPartnerRow['score'].'%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                    }
                }
            ?>
            
            
        </div>
    </div>
    </div>
</form>
<?php require_once "./footer.php"?>
<script src="js/lockScreen.js">//For login feature</script>
</body>
</html>