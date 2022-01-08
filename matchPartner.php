<?php require_once "./db.php"?>
<?php require "loginDetector.php";?>

<?php
    $planId = $_GET['planId'];
    if(isset($_POST['submit'])){
        $number = $_POST['number'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $sql = "insert into partner(`num_people`,`gender`,`age`,`planId`) values ('$number','$gender','$age','$planId')";
        $query = insertFun($connect,$sql);
        if($query){
            echo "<script>window.location.href='./matchPartner.php?planId=".$planId."'</script>";
            exit();
        }else{
            var_dump(mysqli_error($connect));
            exit();
        }
    }
    
    $sql = "select * from `partner` where planID = '$planId'";
    $res = selectFun($connect,$sql);
    if(count($res) > 0){
        echo "<script>window.location.href='./matchResult.php?planId=".$planId."'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once "./header.php"?>
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
    </style>
</head>
<body style = "background-color: honeydew;">
<form action="" method="POST">

<div class="container">
    <h1>Match Partner</h1>
    <hr/>
    <div class="row" style="margin-top:30px">
        <div class="col-md-6">
            <label for="">Number of Travelers</label>
        </div>
        <div class="col-md-6">
            <div class="form-div">
                <select name="number" class="form-style" id="" required>
                    <option value="">Number of Travelers</option>
                    <option value="1-4">1-4</option>
                    <option value="5-8">5-8</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label for="">Gender</label>
        </div>
        <div class="col-md-6">
        <div class="form-div">
                <select name="gender" class="form-style" id="" required>
                    <option value="">Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="noPreference">No preference</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label for="">Age range</label>
        </div>
        <div class="col-md-6">
        <div class="form-div">
                <select name="age" class="form-style" id="" required>
                    <option value="">Age range</option>
                    <option value="18-28">18-28</option>
                    <option value="29-38">29-38</option>
                    <option value="38-48">38-48</option>
                </select>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-6">
            <label for="">Expected Daily Cost</label>
        </div>
        <div class="col-md-6">
        <div class="form-div">
                <select name="Estimated_price" class="form-style" id="" required>
                    <option value="">Daily Cost</option>
                    <option value="50-100">50-100</option>
                    <option value="100-200">100-200</option>
                    <option value="200-400">200-400</option>
                </select>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-6">
            <button name="button" onclick="javascript:history.back(-1)" class="button">Cancel</button>
        </div>
        
        <div class="col-md-6" style="text-align:right">
            <button name="submit" type="submit" class="button">Match Partners</button>
        </div>
    </div>
</div>
</div>
</form>
<?php require_once "./footer.php"?>
<script src="js/lockScreen.js">//For login feature</script>
</body>
</html>