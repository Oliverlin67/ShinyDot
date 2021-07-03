$(document).ready(function(){
    
    $('.boardBlock').on('click', function () {
        window.location = "https://forum.coyu.cc/b/" + $(this).attr("id");
    });
});