$(document).ready(function (){
    /*when click on unlike location/tag */
    $('.unliketag').click(function (){
        var tagid = $(this).attr('id1');
        var userid = $(this).attr('id2');
        $.ajax({
            url: 'rm_fav.php',
            type: 'POST',
            async: false,
            data: {
                'unlikedtag':1,
                'tagid': tagid,
                'userid': userid
            },
            success: function (){

            }
        });
    });

    /*when click on unlike post */
    $('.unlikepost').click(function (){
        var postid = $(this).attr('id1');
        var userid = $(this).attr('id2');
        $.ajax({
            url: 'rm_fav.php',
            type: 'POST',
            async: false,
            data: {
                'unlikedpost':1,
                'postid': postid,
                'userid': userid
            },
            success: function (){

            }
        });
    });
});

