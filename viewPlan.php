<?php
require "db.php";
// select tag selection
$sql = "select * from tag where type = '0'";
$res = selectFun($connect, $sql);
$planID = $_GET['planId'];
$sql = "select * from plan a join tag b on a.destination = b.tagID where planID = '$planID'";
$resForPlan = selectFun($connect,$sql);
// $sql = "select * from favorite where type = '0'";
// $resForFavorite = selectFun($connect,$sql);
// 100089
// echo html_entity_decode($resForPlan[0]);
if(isset($_POST['submit'])){
    $dayContent = htmlentities($_POST['dayContent'],ENT_QUOTES,"UTF-8");
    
    // echo html_entity_decode($dayContent);
    
    $title = $_POST['title'];
    $destination = $_POST['destination'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $sql = "update `plan` set `day_content`='$dayContent',`plan_title` = '$title',`start_date` = '$startDate',`end_date`='$endDate',`destination`='$destination',`userID`='$userID' where planID = $planID";
    if(insertFun($connect,$sql)){
        echo "<script>alert('Update Success!');window.location.href='./plan.php'</script>";
        exit();
    }else{
        echo "<script>alert('Update Fail!');history.back(-1)</script>";
        exit();
    }
    
}
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
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">

    <link rel="stylesheet" href="css/navFooter.css">
    <script src="https://apis.google.com/js/platform.js?hl=en" async defer></script>
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-qhXvdtD2w5dxG_CD8yp_OX_B06MYHGA&libraries=places&callback=initMap&sensor=false"></script>
    <title>Trahoo Plan</title>
    <style>
    .btn-trahoo {
        background: #00CED1;
        color: white
    }
    body{    
        margin: 0;
        padding-top: 138px;
    }
         

    table {
            background: white;
            border: 1px solid rgb(188, 188, 188)
        }

        ol {
            margin-left: 0px
        }
        .textQueryInput{
            display: none;
        }
        form{
            margin-bottom: 30px;
        }
        .deleteTag{
            display: none;
        }
</style>
</head>
<body style = "background-color: honeydew;">
<?php require "loginDetector.php";?>
<?php require "header.php";?>




    <!-- <div class="ptb-100"> -->
    <div class="container">
            <div class="section-title">
                <h2>View Plan</h2>
            </div>
            
            <form action="" method="POST" onsubmit="return form1()">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" disabled id="title" value="<?php echo $resForPlan[0]['plan_title']?>" class="form-style" placeholder="Plan Title" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Destination</label>
                        <select name="destination" disabled id="destination" required class="form-style">
                            <?php
                            foreach ($res as $row) {
                                if($row['content'] == $resForPlan[0]['content']){
                                    echo '<option selected value="' . $row['tagID'] . '">' . $row['content'] . '</option>';
                                }else{
                                    echo '<option value="' . $row['tagID'] . '">' . $row['content'] . '</option>';
                                }
                                
                            }
                            ?>

                        </select>
                        <!-- <input type="text" name="destination" id="destination" class="form-style" placeholder="Plan Destination" required> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Start Date</label>
                        <input type="date" disabled name="startDate" value="<?php echo $resForPlan[0]['start_date']?>" id="startDate" class="form-style" placeholder="Start Date" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">End Date</label>
                        <input type="date" disabled name="endDate" id="endDate" value="<?php echo $resForPlan[0]['end_date']?>" class="form-style" placeholder="End Date" required>
                    </div>
                </div>
                <div class="col-lg-12 buttonGroup" style="text-align:right;">
                
                                        <button type="button" class="button button-trahoo" onclick="javascript:window.location.href='./editPlan.php?planId=<?php echo $planID;?>'">
                                            Edit Plan
                                        </button>
                                        </div>
                <div class="form-group">
                    <input type="hidden" class="dayContent" name="dayContent" value="">
                </div>
                
                                        
                    <!-- <button type="button" class="button button-primary" onclick="createDate()">Creat Date</button>
                    <button type="submit" name="submit" class="button button-primary">Submit</button>
                    <button type="button" class="button button-primary" onclick="javacript:history.back(-1)">Cancel</button> -->
                
            </div>
            </form>
            <div class="row planDay">
                <?php echo html_entity_decode($resForPlan[0]['day_content']);?>

            </div>
           </div>

<?php require "footer.php"?>


<script>
    var dateArr = [];
    var destinationId = "";
    var tagArr = [];
    var createDateFlag = false; 
    var getToday = new Date();
              
    function createDate() {
        destinationId = $("#destination").val();
        var text = $("#destination option:selected").text();
        var today = (new Date()).getTime();
        var startDate = new Date($("#startDate").val());
        var endDate = new Date($("#endDate").val());
        if ($("#startDate").val() == "") {
            alert("The start date required !");
            createDateFlag = false;
            return false;
        }
        if ($("#endDate").val() == "") {
            alert("The end date required !");
            createDateFlag = false;
            return false;
        }

        if (startDate.getTime() > endDate.getTime()) {
            alert("The start date cannot be earlier than the end date !");
            return false;
        } else {
  
            var dataAmount = (endDate.getTime() - startDate.getTime()) / (1 * 24 * 60 * 60 * 1000);
            if (dataAmount > 7) {
                alert("The planned days cannot be more than 7 days !");
                return false;
            }
            var startDateStr = startDate.getFullYear() + "-" + (startDate.getMonth() + 1) + "-" + (startDate.getDate())
            var str = "";
            var strTabContent = "";
            createDateFlag = true;
            for (var i = 1; i <= dataAmount; i++) {
                var date = dateAddDays(startDateStr, i);
                var select = "false";
                var activeTab = "";
                var activeTabContent = "";
                var show = "";
                var obj = {
                    name: "Day " + (i),
                    date: date
                }
                dateArr.push(obj);
                if (i == 1) {
                    select = "true";
                    activeTab = "active";
                    activeTabContent = "active";
                    show = "show";
                }
                str = str + '<li>' +
                    '<a class="button" onclick="tabButton(\''+(i-1)+'\')" data-date="' + date + '">Day ' + (i) + '</a>' +
                    '</li>';
                strTabContent = strTabContent + '<div style="" class="trahoo-tab-pane">' +
                    '<div style="display:flex">' +
                    '<div class=""><h5>' + date + '</h5> </div>' +
                    '<div class="col-lg-8 tagInput" style="margin-left:30px;">' +
                    '<div  style="display:flex;">' +
                    '<div class="form-group inputContent">' +
                    '<h3>Favorite</h3>' +
                    '<input type="hidden" class="h'+date+'" value="">'+
                    '</div>' +
                    '<div class="form-group" style="position:relative;margin-left:15px;">' +
                    '<input type="text" onkeyup="getFavorite(this,\'' + date + '\')"  name="" class="form-style textQueryInput">' +
                    '<table id="ft' + date + '" style="display:none;position:absolute;z-index:99;top:38px;left:0px" class="favoriteTagTable table table-hover"><thead><tr><td>tag</td></td><td>operation</td></tr></thead><tbody><td colspan="2">No data</td></tbody></table></div>' +
                    '</div>' +
                    '<div class="form-group tagInput1" style="position:relative;margin-left:15px;">' +
                    '<ol></ol>' +
                    '</div>' +

                    '<div  style="display:flex;margin-top:30px" class="suggestInput">' +
                    '<div class="form-group inputContent">' +
                    '<h3>Suggestion</h3>' +
                    '</div>' +
                    '<div class="form-group" style="position:relative;margin-left:15px;">' +
                    '<input type="text" onkeyup="getSuggestion(this,\'' + date + '\')"  name="" class="form-style textQueryInput">' +
                    '<table id="st' + date + '" style="display:none;position:absolute;z-index:99;top:38px;left:0px" class="favoriteTagTable table table-hover"><thead><tr><td>tag</td></td><td>operation</td></tr></thead><tbody><td colspan="2">No data</td></tbody></table></div>' +
                    '</div>' +
                    '<div class="form-group tagInput2" style="position:relative;margin-left:15px;">' +
                    '<ol></ol>' +
                    '</div>' +


                    '<div  style="display:flex;margin-top:30px" class="resturantInput">' +
                    '<div class="form-group inputContent">' +
                    '<h3>Restaurant</h3>' +
                    '</div>' +
                    '<div class="form-group" style="position:relative;margin-left:15px;">' +
                    '<input type="text" onkeyup="getResturant(this,\'' + date + '\')"  name="" class="form-style textQueryInput">' +
                    '<table id="rt' + date + '" style="display:none;position:absolute;z-index:99;top:38px;left:0px" class="favoriteTagTable table table-hover"><thead><tr><td>tag</td></td><td>operation</td></tr></thead><tbody><td colspan="2">No data</td></tbody></table></div>' +
                    '</div>' +
                    '<div class="form-group tagInput3" style="position:relative;margin-left:15px;">' +
                    '<ol></ol>' +
                    '</div>' +
                    '<div id="m'+date+'" style="width:500px;height:380px;">'+
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                    // getLocation(text,date);
            }
            $("#pills-tabContent").html(strTabContent);
            $("#pills-tab").html(str);
            $(".trahoo-tab-pane").eq(0).show();

        }
    }
    var map;
    // double check the cotent in create date
    function form1(){
        if(createDateFlag){
            // alert($(".planDay").html());
            $(".dayContent").val($(".planDay").html());
            return true;
        }else{
            alert("You need to create Date!");
            return false;
        }
    }

    function initialize(ip,date) {
        var mapProp = {
            center: ip,
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("m"+date), mapProp);

    }

    function getLocation(text,date) {

        var geocoder = new google.maps.Geocoder();
        
        var address = text;
        if (geocoder) {

            geocoder.geocode({
                    'address': address
                }, function(results, status) {

                    
                    
                    if (status == "OK") {
                        initialize(results[0].geometry.location,date);
                        var place_id = results[0]['place_id'];
                       
                        var value = $(".h"+date).val();
            
            // return false;
            if(value){
                var data = JSON.parse(value);
            }else{
                var data = [];
                
            }
                        
                        for(var i = 0 ; i < data.length ; i++){
                          var  geocoder1 = new google.maps.Geocoder();
                          geocoder1.geocode({
                    'address': data[i]
                }, function(results1, status) {

                    
                    
                    if (status == "OK") {
                       
                        
                        var marker3 = new google.maps.Marker({
                            position: results1[0].geometry.location,
                            map: map,
                            title: data[i]
                        });
                    }
                }
            )
                        }
                    }
                }
            )



            
        }
    }
          
            
            function getFavorite(obj, id) {
                var value = $(obj).val();
                var noDataStr = '<td colspan="2">No data</td>';
                var table = $("#ft" + id);
                // if(value == ""){

                // }else{
                table.show();
                $.ajax({
                    url: "./getFavorite.php",
                    type: "POST",
                    data: {
                        destinationId: destinationId,
                        key: value
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.res.length > 0) {
                            var str = "";
                            for (var i = 0; i < res.res.length; i++) {
                                str = str + "<tr><td>" + res.res[i].content + "</td><td><button class='button button-primary' onclick='selectFavoriteTag(this,\"" + res.res[i].content + "\",\"" + id + "\")'>select</button></td></tr>";
                            }
                            table.find("tbody").html(str);
                        } else {
                            table.find("tbody").html("<tr>" + noDataStr + "</tr>");
                        }
                    }
                })


            }

            function selectFavoriteTag(obj, content,id) {
                var value = $(".h"+id).val();
                if(value){
                    var data = JSON.parse(value);
                    
                }else{
                    var data = [];
                }
                
                data.push(content);
                data = JSON.stringify(data);
                console.log(data);
                $(".h"+id).val(data);
                getLocation(content,id)
                $(obj).parents(".tagInput").find(".tagInput1 ol").append("<li class='selectTagContent'>" + content + "<button onclick='cancelTag(this,\""+content+"\",\""+id+"\")' class='deleteTag button button-danger'>Delete</button></li>");
            }

            function cancelTag(e,content,id){
                var value = $(".h"+id).val();
                if(value){
                    var data = JSON.parse(value);
                }else{
                    var data = [];
                }
                var newArr = [];

     for(var i = 0;i<data.length;i++){
     
           if(data[i] != content){
                 newArr.push(data[i]);
           }
     }
                data = JSON.stringify(newArr);
                $(".h"+id).val(data);
                console.log($(".h"+id).val())
                getLocation(content,id);
                $(e).parents(".selectTagContent").remove();

            }

            function selectSuggestionTag(obj, content,id) {
                var value = $(".h"+id).val();
                if(value){
                    var data = JSON.parse(value);
                    
                }else{
                    var data = [];
                }
                
                data.push(content);
                data = JSON.stringify(data);
                console.log(data);
                $(".h"+id).val(data);
                getLocation(content,id)
                $(obj).parents(".tagInput").find(".tagInput2 ol").append("<li class='selectTagContent'>" + content + "<button onclick='cancelTag(this,\""+content+"\",\""+id+"\")' class='deleteTag button button-danger'>Delete</button></li>");
            }

            function selectResturantTag(obj, content,id) {
                var value = $(".h"+id).val();
                if(value){
                    var data = JSON.parse(value);
                    
                }else{
                    var data = [];
                }
                
                data.push(content);
                
                data = JSON.stringify(data);
                console.log(data);
                $(".h"+id).val(data);
                getLocation(content,id)
                $(obj).parents(".tagInput").find(".tagInput3 ol").append("<li class='selectTagContent'>" + content + "<button onclick='cancelTag(this,\""+content+"\",\""+id+"\")' class='deleteTag button button-danger'>Delete</button></li>");
            }

            function getSuggestion(obj, id) {
                var value = $(obj).val();

                var noDataStr = '<td colspan="2">No data</td>';
                var table = $("#st" + id);

                table.show();
                $.ajax({
                    url: "./getSuggestion.php",
                    type: "POST",
                    data: {
                        destinationId: destinationId
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.res.length > 0) {
                            var str = "";
                            for (var i = 0; i < res.res.length; i++) {
                                str = str + "<tr><td>" + res.res[i].content + "</td><td><button class='button button-primary' onclick='selectSuggestionTag(this,\"" + res.res[i].content + "\",\"" + id + "\")'>select</button></td></tr>";

                            }
                            table.find("tbody").html(str);
                        } else {
                            table.find("tbody").html("<tr>" + noDataStr + "</tr>");
                        }
                    }
                })


            }

            function getResturant(obj, id) {
                var value = $(obj).val();
                var noDataStr = '<td colspan="2">No data</td>';
                var table = $("#rt" + id);
                table.show();
                $.ajax({
                    url: "./getResturant.php",
                    type: "POST",
                    data: {
                        destinationId: destinationId
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.res.length > 0) {
                            var str = "";
                            for (var i = 0; i < res.res.length; i++) {
                                str = str + "<tr><td>" + res.res[i].content + "</td><td><button class='button button-primary' onclick='selectResturantTag(this,\"" + res.res[i].content + "\",\"" + id + "\")'>select</button></td></tr>";

                            }
                            table.find("tbody").html(str);
                        } else {
                            table.find("tbody").html("<tr>" + noDataStr + "</tr>");
                        }
                    }
                })


            }

            function createInput(obj) {
                $(obj).parents(".inputContent").append('<div class="form-group">' +
                    '<input type="text" name="" class="form-style">' +
                    '</div>');
            }

            function dateAddDays(dateStr, dayCount) {
                var tempDate = new Date(dateStr.replace(/-/g, "/")); 
                var resultDate = new Date((tempDate / 1000 + (86400 * dayCount)) * 1000);
                var resultDateStr = resultDate.getFullYear() + "-" + (resultDate.getMonth() + 1) + "-" + (resultDate.getDate()); 
                return resultDateStr;
            }

            $("body").click(function() {
                $("table").hide();
            })
    
    function tabButton(index){
        $(".trahoo-tab-pane").hide();
        $(".trahoo-tab-pane").eq(index).show();
    }

</script>
<script src="js/lockScreen.js">//For login feature</script>

</body>
</html>