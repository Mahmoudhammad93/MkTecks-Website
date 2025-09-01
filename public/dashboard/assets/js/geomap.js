$(document).ready(function (){
    $("#latitude").on("input", function (e) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    });
    $("#longitude").on("input", function (e) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    });
});


if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
} else {
    x.innerHTML = "Geolocation is not supported by this browser.";
}

function showPosition(position) {
    if ($("#latitude").val() != "") {
        var latt = parseFloat($("#latitude").val());
        var long = parseFloat($("#longitude").val());
    } else {
        var latt = position.coords.latitude;
        var long = position.coords.longitude;
    }

    // The location of Uluru
    const uluru = {
        lat: latt,
        lng: long,
    };

    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: uluru,
    });

    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
        position: uluru,
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
    });

    google.maps.event.addListener(marker, "dragend", function (marker) {
        console.log(marker);
        var latLng = marker.latLng;
        currentLatitude = latLng.lat();
        currentLongitude = latLng.lng();
        $("#latitude").val(currentLatitude);
        $("#longitude").val(currentLongitude);
    });

    $("#latitude").val(latt);
    $("#longitude").val(long);
}
