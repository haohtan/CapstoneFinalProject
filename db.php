<?php
    session_start();
    // connection 
    $connect = mysqli_connect("db.luddy.indiana.edu","i494f20_team41","my+sql=i494f20_team41","i494f20_team41");
    
    // get data
    function selectFun($connect,$sql){
            
        $query = mysqli_query($connect,$sql);
            $res = mysqli_fetch_all($query,1);
            if($query){
                return $res;
            }else{
                return false;
            }
    }
    // update data
    function updateFun($connect,$sql){
        
            $query = mysqli_query($connect,$sql);
            $num = mysqli_affected_rows($connect);
            if($num > 0){
                return true;
            }else{
                return false;
            }
    }
    // insert data 
    function insertFun($connect,$sql){
            $query = mysqli_query($connect,$sql);
            $num = mysqli_affected_rows($connect);
            if($num > 0){
                return true;
            }else{
                return false;
            }
    }
    // delete data
    function deleteFun($connect,$sql){
        $query = mysqli_query($connect,$sql);
        $num = mysqli_affected_rows($connect);
        if($num > 0){
            return true;
        }else{
            return false;
        }
    }

?>
