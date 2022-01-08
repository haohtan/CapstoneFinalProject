<?php
// This file checks wheather user is the first user or not
// if user(first) -> upload user information to DB -> profile(edit personal information)
// if user(not first) -> to original website
    session_start();
    include('config.php');

    //It will Attempt to exchange a code for an valid authentication token.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if (!isset($token['error'])){
        //Set the access token used for requests
        $google_client->setAccessToken($token['access_token']);

        //Store "access_token" value in $_SESSION variable for future use.
        $_SESSION['access_token'] = $token['access_token'];
            
        //Create Object of Google Service OAuth 2 class
        $google_service = new Google_Service_Oauth2($google_client);
            
        //Get user profile data from google
        $data = $google_service->userinfo->get();

        // Get user email
        $useremail = $data['email'];
        
        // Connect to the database
        $con = mysqli_connect("db.luddy.indiana.edu","i494f20_team41","my+sql=i494f20_team41", "i494f20_team41");

        if (!$con){
            die("Connection failed:".mysqli_connect_error());header("Location: profile.php");
        }	
        else{
            $checkEmail = "select userID,firstN,avatar_url from profile where Email = \"".$useremail."\"";
            $result1 = $con->query($checkEmail);

            if ($result1->num_rows==0){
                $userfirst = $data['given_name'];
                $userlast = $data['family_name'];        
                $useravatar = $data['picture'];
                // upload user's avatar to service
                file_put_contents("imgs/" .$useremail."-attar".'.jpg', file_get_contents($useravatar));
                
                $useravatar = "imgs/" .$useremail."-attar".'.jpg';
                echo $useravatar;
                $userFullName = $userfirst." ".$userlast;
                // if user(first) -> upload user information to DB -> profile(edit personal information)
                $create_user = "insert into profile ( email, joinDate, firstN, middleN, lastN, fullN, gender,avatar_url) values ( '".$useremail."', '".date("Y/m/d")."', '".$userfirst."', null, '".$userlast."', '".$userFullName."',0 , '".$useravatar."');";
                $con->query($create_user);

                $getId = "select userID,firstN,avatar_url from profile where Email = \"".$useremail."\"";
                $result2 = $con->query($getId);
                while($row = $result2->fetch_assoc()) 
                {
                    $_SESSION["user_first"] = $row["firstN"];
                    $_SESSION["userID"] = $row["userID"];  
                    $_SESSION["avatarUrl"] = $row["avatar_url"];             
                  
                }
                // to edit profile pg
                header("Location: profile.php");
            }

            else
            {
                while($row = $result1->fetch_assoc()) 
                {
                    // Global variables
                    $_SESSION["user_first"] = $row["firstN"];
                    $_SESSION["userID"] = $row["userID"];       
                    $_SESSION["avatarUrl"] = $row["avatar_url"];             
                }

                header("Location:".$_SESSION["current_url"]);

            }
        }

        $con->close();
    }else{
        header("Location: profile.php");
    }

?>