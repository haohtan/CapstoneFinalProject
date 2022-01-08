<?php
session_start();
?>
<?php
$server = "db.luddy.indiana.edu";
$username = "i494f20_team41";
$password = "my+sql=i494f20_team41";
$dbname = "i494f20_team41";
$conn = mysqli_connect($server, $username, $password, $dbname);
if(!$conn){
    die("connection failed: ".mysqli_connect_error(). "<br>");
}


$output = "";
//collect
if(!empty($_GET['match_type'])){
    $selecttype = $_GET['match_type'];
}

if(isset($_GET['search'])){
    $searchinfo = $_GET['search'];
    $output = '';
    if ($selecttype == 'user'){
        $sql="SELECT * FROM profile WHERE fullN LIKE '%$searchinfo%' OR userID LIKE '%$searchinfo%'";
        $result = mysqli_query($conn,$sql);
        $queryresult = mysqli_num_rows($result);
        if ($queryresult == 0){
            $output .= '<li class="result_li">'."There was no search results!".'</li>';
        }else{
            while($row = mysqli_fetch_assoc($result)){
                $fname = $row['fullN'];
                $userid = $row['userID'];
                $output .= '<li class="result_li">'.($userid).' '."<br>".ucwords($fname).'</li>';
            }
        }
    } else{
        $sql="SELECT * FROM tag WHERE content LIKE '%$searchinfo%' OR tagID LIKE '%$searchinfo%'";
        $result = mysqli_query($conn,$sql);
        $queryresult = mysqli_num_rows($result);
        if ($queryresult == 0){
            $output .= '<li class="result_li">'."There was no search results!".'</li>';
        }else{
            while($row = mysqli_fetch_assoc($result)){
                $tagid = $row['tagID'];
                $content = $row['content'];
                $output .= '<li class="result_li">'.$tagid.' '."<br>".ucwords($content).'</li>';
            }
        }
    }

    echo $output;

}
//after click submit btn
if($_SERVER["REQUEST_METHOD"] =="POST") {
    $user_input = $_POST['search_text'];
    $selected_type = $_POST['match_type'];

    if ($selected_type == 'user') {
        $check_sql = "SELECT userID FROM profile WHERE CONCAT(userID,' ',fullN) LIKE '%$user_input%'";
        $check_result = mysqli_query($conn, $check_sql);
        $check_queryresult = mysqli_num_rows($check_result);
        if ($check_queryresult == 1) {
            while ($row = $check_result->fetch_assoc())
            $targetID = $row['userID'];
            header('Location: profile.php'.'?target_userID='.$targetID);
        } else {
            echo '<script type="text/javascript">alert("Sorry, there are no results related to your input");</script>';
            echo '<body style="background-color: Moccasin">';
            echo '<p align="center"><font color=darkred font face="verdana" size="7pt">We apologize for the inconvenience</font></p>';
            echo '<p align="center"><font color=DarkOliveGreen font face="verdana" size="5pt">No search results related to your input were found.</font></p>';
            echo '<p align="center"><font color=black font face="verdana" size="5pt">Please wait 3 seconds, we will take you back to the homepage.</font></p>';
            header("refresh:3;'index.php'");
            exit(0);
        }
    } elseif ($selected_type == 'location') {
        $check_sql = "SELECT tagID FROM tag WHERE CONCAT(tagID,' ',content) LIKE '%$user_input%'";
        $check_result = mysqli_query($conn, $check_sql);
        $check_queryresult = mysqli_num_rows($check_result);
        if ($check_queryresult == 1) {
            // $_SESSION["target_tagID"] = number_format($check_result);
            $arr = explode(" ",$user_input);
            header('Location: community.php?tagID='.$arr[0]);
        } else {
            echo '<script type="text/javascript">alert("Sorry, there are no results related to your input");</script>';
            echo '<body style="background-color: Moccasin">';
            echo '<p align="center"><font color=darkred font face="verdana" size="7pt">We apologize for the inconvenience</font></p>';
            echo '<p align="center"><font color=DarkOliveGreen font face="verdana" size="5pt">No search results related to your input were found.</font></p>';
            echo '<p align="center"><font color=black font face="verdana" size="5pt">Please wait 3 seconds, we will take you back to the homepage.</font></p>';
            header("refresh:3;'index.php'");
            exit(0);
        }
    }
}
mysqli_close($conn);
?>