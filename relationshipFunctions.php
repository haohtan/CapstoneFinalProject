<?php
    //Relationship rule! UserAID follow UserBID
    function checkRelationship($user1,$user2){
        $db = mysqli_connect("db.luddy.indiana.edu", "i494f20_team41", "my+sql=i494f20_team41", "i494f20_team41");

        $sql = "select status from relationship where (userAID =". $user1." and userBID = ". $user2.")";
        $result = $db -> query($sql);
        if ($result->num_rows > 0) return true;
        else return false;
    
    }

    function createRelationship($user1,$user2){
        $db = mysqli_connect("db.luddy.indiana.edu", "i494f20_team41", "my+sql=i494f20_team41", "i494f20_team41");

        $sql = "insert into relationship(userAID, userBID) values(".$user1.",".$user2.")";
        $db->query($sql);
    }

    function deleteRelationship($user1,$user2){
        $db = mysqli_connect("db.luddy.indiana.edu", "i494f20_team41", "my+sql=i494f20_team41", "i494f20_team41");

        $sql = "DELETE FROM relationship WHERE (userAID = ".$user1. " and userBID = ".$user2.")";
        $db->query($sql);
    }

    function displayProfile($user1,$user2,$privacy){
        if ((($privacy == 2) & (checkRelationship($user1,$user2))) || ($privacy == 1)) return true;
        else return false;
    }
    
?>