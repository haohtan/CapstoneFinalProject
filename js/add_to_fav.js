$(document).ready(function (){
    /*when user click like*/
    $('.like').click(function (){
        var tagid = $(this).attr('id1');
        var userid = $(this).attr('id2');
        $.ajax({
            url: 'add_to_fav.php',
            type: 'POST',
            async: false,
            data: {
                'liked':1,
                'tagid': tagid,
                'userid': userid
            },
            success: function (response){

            }
        });
    });
    /*when click on unlike*/
    $('.unlike').click(function (){
        var tagid = $(this).attr('id1');
        var userid = $(this).attr('id2');
        $.ajax({
            url: 'add_to_fav.php',
            type: 'POST',
            async: false,
            data: {
                'unliked':1,
                'tagid': tagid,
                'userid': userid
            },
            success: function (){

            }
        });
    });
});

