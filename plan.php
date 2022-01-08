<?php
require "loginDetector.php";
require_once "db.php";

$sql = "select * from `plan` a left join tag b on a.destination = b.tagID where a.`userID` = '$userID' order by a.`planID` desc";
$res = selectFun($connect, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="google-signin-client_id" content="40069760996-m7meg75slq4mhd9kd5hc4lklva6fq2co.apps.googleusercontent.com">
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" rel="stylesheet">
    
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/plan.css">

    <link rel="stylesheet" href="css/navFooter.css">

    <title>Trahoo Plan</title>
    <style>
    h1, h2, h3, h4, h5, h6 {
        font-family: Arial, Helvetica, sans-serif;
    }
    .btn-trahoo {
        background: #00CED1;
        color: white
    }
    body{
        /* style="padding-top:138px"; */
        margin: 0;
        padding-top: 138px;

    }
    .col-lg-8{
        background-color: #ABE8D9;
        border-radius: 25px;

    }
    .col-lg-4{
        background-color: #ABE8D9;
        border-radius: 25px;

    }
    
    .button-trahoo:hover {
        background-color: blue;
        color: #ffffff;
    }

</style>

</head>


<body style = "background-color: honeydew;">
    <?php require_once "header.php";?>
    

<!-- End Page Title -->


<div class="ptb-100">
    <div class="container">
        <div class="section-title">
            <h2>Plan List</h2>
        </div>
        <!-- <form action="" method="POST"> -->

        <div class="row">
            <?php if (count($res) > 0) {
                foreach ($res as $row) {
                    echo '<div class="col-lg-10" style="margin-top:15px">
                    <div class="trahoo-card bg-light text-dark">
                        <div class="trahoo-card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3>' . $row['plan_title'] . '</h3>
                                    <h4>' . $row['content'] . '</h4>
                                    <h5>' . $row['start_date'] . ' - ' . $row['end_date'] . '</h5>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <a target="_blank" href="./viewPlan.php?planId=' . $row['planID'] . '">
                                        <button class="button button-trahoo" style="margin-top:8px">
                                            View Plan
                                        </button>
                                        </a>
                                    </div>
                                    <div class="form-group">
                                        <button class="button button-trahoo" style="margin-top:8px" onclick="deletePlan(' . $row['planID'] . ')">
                                            Delete Plan
                                        </button>
                                    </div>
                                    <div class="form-group">
                                    <a href="./matchPartner.php?planId=' . $row['planID'] . '">
                                        <button class="button button-trahoo" style="margin-top:8px">
                                            Match Partner
                                        </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                }

            ?>


            <?php } else { ?>
                <div class="col-lg-10">
                    <h3>No Plan</h3>
                </div>
            <?php } ?>
            <div class="col-lg-2">


                <input style="position:fixed;top:138px" type="button" name="" id="createPlan" onclick="javascript:window.location.href='./createPlan.php'" class="button button-trahoo" value="Create Plan">

            </div>
        </div>

    </div>
</div>
<?php
require_once "footer.php";
?>



<script>
    function deletePlan(planID) {
        if (confirm("Are you sure to delete this plan?")) {
            window.location.href = "deletePlan.php?planID=" + planID
        }
    }
</script>
<script src="js/lockScreen.js">//For login feature</script>
</body>
</html>