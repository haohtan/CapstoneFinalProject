<?php
session_start();
function launchFollows($myID, $type){
    //this function prints followers/following
    //type 0 is followers, 1 is following

    $followersOutput = '';
    $db = mysqli_connect("db.luddy.indiana.edu", "i494f20_team41", "my+sql=i494f20_team41", "i494f20_team41");
    
    if ($type == 0) $sql = "select userAID from relationship where userBID = ".$GLOBALS['displayID'];
    else $sql = "select userBID from relationship where userAID = ".$GLOBALS['displayID'];

    $result = $db -> query($sql);
    while($row = $result->fetch_assoc()) 
    {
        if ($type == 0) $userID = $row["userAID"];
        else $userID = $row["userBID"];

       //create a user
        $user2 = new ProfileUser(); 
        $user2->setID($userID);
        $followersOutput .= '<div class = "user-items"><div class = "user-items-info"><img class="attar" src="'.$user2->getAvatar().'" style ="width:50px;height:50px; top:0px;"><div class = "info-name"><a href="https://cgi.luddy.indiana.edu/~team41/team-41/profile.php?target_userID='.$user2->getID().'"><p style="font-size:15px;">'.$user2->getFull().'</p></a><p>ID:'.$user2->getID().'</p></div></div>';

        if (checkRelationship($myID, $user2->getID())) $followersOutput .= '<form method="post" action=""><input style ="width:0px;height:0px; " type="hidden" id="custId" name="custId" value="'.$user2->getID().'"><button class="m-2 btn btn-trahoo btn-follow btn-unfollow" name="unfollow" >Unfollow</button></form></div>';
            
        else $followersOutput .= '<form method="post" action=""><input type="hidden" id="custId" name="custId" value="'.$user2->getID().'"><button class="m-2 btn btn-trahoo btn-follow " name="follow" ">Follow</button></form></div>';
        
    }

    echo $followersOutput;
}

    
?>                        