<?php session_start(); ?>
<?php
include('config.php');

if(!isset($_SESSION["userID"])){
    // get url from current site
    header("Location: https://cgi.luddy.indiana.edu/~team41/team-41/index.php");
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

    <link rel="stylesheet" href="css/navFooter.css">

    <title>Trahoo Create Plan</title>
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

<link rel="stylesheet" href="css/navFooter.css">
<link rel="stylesheet" href="css/style.css">
</head>
<body style = "background-color: honeydew;">
    
<?php require_once "header.php";?>


<div class="">
    <div class="container">
        
            <div class="section-title">
                <h2>Create Post</h2>
            </div>
            <form action="./createpost.php" method="POST" enctype="multipart/form-data" onsubmit="return form1()">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-style" placeholder="Post title" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Cost</label>
                            <input type="number" name="cost" class="form-style" placeholder="Cost Per Day" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" name="description" class="form-style" placeholder="Post your Description" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                       
                        <div class="tab-button">
                            <button class="button" onclick="tabButton(0)" type="button" id="">Content</button>
                            <button class="button" onclick="tabButton(1)" type="button" id="">Images</button>
                            <button class="button" onclick="tabButton(2)" type="button" id="">videos</button>
                            <button class="button" onclick="tabButton(3)" type="button" id="">Tag</button>
                        </div>
                        <div class="trahoo-tab-content">
                            <div class="trahoo-tab-pane active" id="pills-content" role="tabpanel" aria-labelledby="pills-content-tab">
                                <textarea name="content" id="content" cols="30" rows="10" class="form-style"></textarea>
                            </div>
                            <div class="trahoo-tab-pane" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab">
                                <div class="form-group">
                                    <button type="button" class="button button-primary" onclick="createImagesInput()">Create Input</button>
                                </div>
                                <div class="form-inline imagesInput">
                                    <input type="file" name="images[]" accept="image/*" class="form-style">
                                </div>
                            </div>
                            <div class="trahoo-tab-pane" id="pills-videoes" role="tabpanel" aria-labelledby="pills-videoes-tab">
                                <div class="form-group">
                                    <button type="button" class="button button-primary" onclick="createVideoesInput()">Create Input</button>
                                </div>
                                <div class="form-inline videoesInput">
                                    <input type="file" name="videoes[]" accept="video/*" class="form-style">

                                </div>

                            </div>
                            <div class="trahoo-tab-pane fade" id="pills-tag" role="tabpanel" aria-labelledby="pills-tag-tab">
                                <div class="form-inline">
                                    <input id="tagContentValue" type="hidden" name="tagContentValue" value="[]">
                                    <input type="text" name="tag" class="form-style" id="tag" onkeyup="getTag()">
                                    <div style="display:flex;flex-wrap:wrap" class="selectTag">
                                        
                                    </div>
                                    
                                    <table class="trahoo-table">
                                        <tr>
                                            <td>Content</td>
                                            <td>Operation</td>
                                        </tr>
                                        <tbody id="tbody">
                                        <tr >
                                            <td colspan="2">Not Data</td>
                                            
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>


                </div>
                <div class="text-center" style="margin-top:15px;width:100%;justify-content:space-between;display:flex">
                    <input type="button" name="submit" class="button button-danger" onclick="javscript:history.back(-1)" value="Cancel" >
                    <input type="submit" name="submit" class="button button-primary" value="Publish">

                </div>

        
        </form>
    </div>
</div>

<?php
require_once "footer.php";
?>



<script>
    var tagArr = [];
    
    function createImagesInput() {
        $("#pills-images").append('<div class="form-inline imagesInput">' +
            '<input type="file" name="images[]" accept="image/*" class="form-style">' +
            '<button type="button" class="button button-danger" onclick="deleteImagesInput(this)">Delete</button>' +
            '</div>');
    }

    function createVideoesInput() {
        $("#pills-videoes").append('<div class="form-inline videoesInput">' +
            '<input type="file" name="videoes[]" accept="video/*" class="form-style">' +
            '<button type="button" class="button button-danger" onclick="deleteVideoesInput(this)">Delete</button>' +
            '</div>');
    }

    function deleteImagesInput(obj) {
        $(obj).parents(".imagesInput").remove();
    }

    function deleteVideoesInput(obj) {
        $(obj).parents(".videoesInput").remove();
    }

    function getTag(){
        var inputValue = $("#tag").val();
        var data = {
            "tagValue":inputValue
        }
        // console.log(data);
        $.ajax({
            url:"getTag.php",
            type:"post",
            data:data,
            dataType:"json",
            success:function(res){
                $("#tbody").html();
                if(res.res.length == 0){
                    $("#tbody").html('<td colspan="2">Not Data</td>');
                    
                }else{
                    var str = "";
                    for(var i = 0 ; i < res.res.length ; i++){
                        str = str + '<tr><td>'+res.res[i]['content']+'</td><td><button type="button" class="button button-primary" onclick="selectTagContent(\''+res.res[i]['tagID']+'\',\''+EscapeChar(res.res[i]['content'])+'\')">select</button></td></tr>';
                    }
                    $("#tbody").html(str);
                }
            },
            error:function(e){
                console.log(e);
            }
        })
    }

    function EscapeChar(HaveSpecialval) {
            
            HaveSpecialval = HaveSpecialval.replace(/\'/g, "\\\'");

            
            HaveSpecialval = HaveSpecialval.replace(/\'/g, "&acute;");
            return HaveSpecialval;
        }

    function selectTagContent(id,content){
        var arr = {
            "id":id,
            "content":content
        }
        for(var i = 0 ; i < tagArr.length ; i++){
            if(tagArr[i].id == id){
                alert("This tag is already exits!");
                return false;
            }
        }
        tagArr.push(arr);
        $("#tagContentValue").val(JSON.stringify(tagArr));
        $(".selectTag").append('<div class="tagContent"><button type="button" class="button button-primary" type="button">'+content+'</button><button onclick="deleteTag(this,\''+id+'\')" type="button" class="button button-danger">×</button></div>');
    }
    function deleteTag(obj,id){
        $(obj).parents('.tagContent').remove();
        for(var i = 0 ; i < tagArr.length ; i++){
            if(tagArr[i].id == id){
                tagArr.splice(i,1);
            }
        }
        $("#tagContentValue").val(JSON.stringify(tagArr));
    }

    function formValue(){
        if($("#content").val() == ""){
            alert("Content required.");
            return false;
        }
    }

    $(".trahoo-tab-pane").eq(0).show();
    function tabButton(index){
        $(".trahoo-tab-pane").hide();
        $(".trahoo-tab-pane").eq(index).show();
    }
</script>
<script src="js/lockScreen.js">//For login feature</script>
</body>
</html>