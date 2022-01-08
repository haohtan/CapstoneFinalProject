var value;
var txt;
value = $("input[name='match_type']").val();
txt = $("input[name='search_text']").val();
$(document).ready(function(){ //search box
    $('input[type=radio]').click(function(e) {//jQuery works on clicking radio box
        value = $(this).val();
        ajaxfunc();
    });
    $('#search_text').keyup(function () {
        txt = $(this).val();
        ajaxfunc();
    });
});
$(document).on("click","li",function (){
    $('#search_text').val($(this).text());
    $('#result').fadeOut("fast");
});

function ajaxfunc(){
    if (!txt || !value) {
        $('#result').html('');
        $('#result').fadeOut('');
        return;
    }
    $.ajax(
        {
            url: "searchbar.php",
            method: "GET",
            cache: false,
            data: {'search': txt, 'match_type': value},
            dataType: "text",
            success: function (data) {
                $('#result').html(data);
                $('#result').fadeIn();
            }
        }
    );
};


/*
$(document).ready(function(){ //search box
    var value = $("input[name='match_type']").val();
    var txt = $("input[name='search_text']").val();
    $('input[type=radio]').click(function(e) {//jQuery works on clicking radio box
        value = $(this).val();
        ajaxfunc(txt, value);
    });
    var txt = $("input[name='search_text']").val();
    $('#search_text').keyup(function () {
        var txt = $(this).val();
        if (txt !== "") {
            ajaxfunc(txt, value);
        } else {
            $('#result').html('');
            $('#result').fadeOut('');
        }
    });
});
$(document).on("click","li",function (){
    $('#search_text').val($(this).text());
    $('#result').fadeOut("fast");
});

function ajaxfunc(txt,value){
    $.ajax(
        {
            url: "searchbar.php",
            method: "GET",
            cache: false,
            data: {search: txt, 'match_type': value},
            dataType: "text",
            success: function (data) {
                $('#result').html(data);
                $('#result').fadeIn();
            }
        }
    );
};*/
