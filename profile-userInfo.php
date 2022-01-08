<?php 
session_start();
// The class take a userID and return user profile
class ProfileUser{
    private $userID;
    private $userEmail;
    private $userAvatar;
    private $userBackground; 
    private $userFirst;
    private $userMiddle;
    private $userLast;
    private $userFull;
    private $userPrivacy;
    private $userSign;
    private $userPhonenum;
    private $userDOB;
    private $userJoin;
    private $userVerificationStatus;
    private $userverification;
    private $userGender;
    protected $db;

    function setID($id){
        $this->db = mysqli_connect("db.luddy.indiana.edu", "i494f20_team41", "my+sql=i494f20_team41", "i494f20_team41");
        $sql = "select * from profile where userID =". $id;
        $result = $this->db -> query($sql);
        while($row = $result->fetch_assoc()) 
        {
            $this->userID = $row["userID"];
            $this->userEmail = $row["email"];
            $this->userAvatar = $row["avatar_url"];
            $this->userBackground = $row["backgroundIMG"];
            $this->userFirst = $row["firstN"];
            $this->userMiddle = $row["middleN"];
            $this->userLast = $row["lastN"];
            $this->userFull = $row["fullN"];
            $this->userPrivacy = $row["privacySetting"];
            $this->userSign = $row["sign"];
            $this->userPhonenum = $row["phoneNum"];
            $this->userDOB = $row["dob"];
            $this->userJoin = $row["joinDate"];
            $this->userVerificationStatus = $row["verificationStatus"];
            $this->userverification = $row["verification"];      
            $this->userGender = $row["gender"];            
        }
    }
    //return one element
    function getID(){ return $this->userID;}
    function getEmail(){ return $this->userEmail;}
    function getAvatar(){ return $this->userAvatar;}
    function getBackground(){ return $this->userBackground;}
    function getFirst(){ return $this->userFirst;}
    function getMiddle(){ return $this->userMiddle;}
    function getLast(){ return $this->userLast;}
    function getFull(){ return $this->userFull;}
    function getPrivacy(){ return $this->userPrivacy;}
    function getSign(){ return $this->userSign;}
    function getPhone(){ return $this->userPhonenum;}
    function getDOB(){ return $this->userDOB;}
    function getJoinDate(){ return $this->userJoin;}
    function getVeriStatus(){ return $this->userVerificationStatus;}
    function getVerification(){ return $this->userverification;}
    function getGender(){return $this->userGender;}

    //change info
    function setFirst($new){
        $sql = "UPDATE profile SET firstN=\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userFirst  = $new;

    }
    function setMiddle($new){
        $sql = "UPDATE profile SET   middleN=\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userMiddle  = $new;

    }
    function setLast($new){
        $sql = "UPDATE profile SET  lastN =\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userLast  = $new;


    }
    function setFull($new){
        $sql = "UPDATE profile SET  fullN =\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userFull  = $new;

    }
    function setPrivacy($new){
        $sql = "UPDATE profile SET  privacySetting =\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userPrivacy  = $new;

    }
    function setSign($new){
        $sql = "UPDATE profile SET  sign=\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userSign  = $new;

    }
    function setPhone($new){
        $sql = "UPDATE profile SET  phoneNum =\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userPhone  = $new;

    }
    function setDOB($new){
        $sql = "UPDATE profile SET  dob =\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userDOB  = $new;

    }

    function setGender($new){
        $sql = "UPDATE profile SET gender=\"".$new."\" where userID =".$this->userID;
        ($this->db)->query($sql);
        $this->userGender  = $new;

    }

    function setAvatar($new){
        file_put_contents("imgs/" .$this->userEmail."-attar".'.jpg', $new);
    }

    function setBackground($new){
        file_put_contents("imgs/" .$this->userEmail."-background".'.jpg', $new);
        $this->userBackground = "imgs/" .$this->userEmail."-background".'.jpg';
        $sql = "UPDATE profile SET backgroundIMG=\"".$this->userBackground."\" where userID =".$this->userID;
        ($this->db)->query($sql);
    }
    
    function setVerification($new){
        file_put_contents("imgs/" .$this->userEmail."-verification".'.jpg', $new);
        $this->userverification = "imgs/" .$this->userEmail."-verification".'.jpg';
        $sql = "UPDATE profile SET verification=\"".$this->userverification."\" where userID =".$this->userID;
        ($this->db)->query($sql);
    }


    //Create relationship

    function createRelationship($user2){
        $sql = "insert into relationship(userAID, userBID) values(".$id.",".$user2.")";
    }

    //Get my posts
    function getMyPosts(){
        //return arr
        $sql = "select * from post where userID =".$this->userID;
        $result = $this->db -> query($sql);
        $res = mysqli_fetch_all($result,1);
        return $res;    
        
    }
}


?>

