function openModal(tagContent){
    $("#modal").fadeIn();
    $(".location").html(tagContent);
    $(".Rating").html("");
    $(".Cost").html("");
    $(".Address").html("");
    $(".Hours").html("")
    initMap(tagContent);
}
function closeModal(){
    $("#modal").fadeOut();
}
function initMap(tagContent) {
    if(google){
    var sydney = new google.maps.LatLng(-33.867, 151.195);

    map = new google.maps.Map(document.getElementById('map'), {center: sydney, zoom: 15});

    var findPlaceIdRequest = {
        query: tagContent,
        fields: ['place_id']
    };

    var service = new google.maps.places.PlacesService(map);
    service.findPlaceFromQuery(findPlaceIdRequest, function(results,status){
    console.log(results);

    var getPlaceDetailRequest = {
        placeId: results[0].place_id,
        fields: ['rating','price_level','geometry','formatted_address','opening_hours']
    };
    service.getDetails(getPlaceDetailRequest, function(results1,status1){
        map.setCenter(results1.geometry.location);
    var marker = new google.maps.Marker({
        position: results1.geometry.location,
        map: map,
        title: tagContent
    });

    console.log(results1);

    if(results1.rating){
        $(".Rating").html("Rating : "+results1.rating);
    }else{
        $(".Rating").html("No rating");
    }
    // 0 — Free
    // 1 — Inexpensive
    // 2 — Moderate
    // 3 — Expensive
    // 4 — Very Expensive
    if(results1.price_level){
        var str = "";
    if(results1.price_level == "0"){
        str = "Free";
    }
    if(results1.price_level == "1"){
        str = "$";
    }
    if(results1.price_level == "2"){
        str = "$$";
    }
    if(results1.price_level == "3"){
        str = "$$$";
    }
    if(results1.price_level == "4"){
        str = "$$$$";
    }

    $(".Cost").html("Price Level : "+str);
    }else{
        $(".Cost").html("No price level");
    }

    if(results1.formatted_address){
        $(".Address").html("Address : "+results1.formatted_address);
    }else{
        $(".Address").html("No address");
    }

    if(results1.opening_hours){
        console.log(results1.opening_hours)
        $(".Hours").html("Opening Hours : </br>"+results1.opening_hours.weekday_text.join(";<br>"));
    }else{
        $(".Hours").html("No opening hours");
    }
    console.log(results1.rating);
    })
    });
    }else{
        alert("Init google map fail !")
    }
}