
$(document).ready(function () {

    var pgurl = window.location;


    $(".nav-stacked li a").each(function () {
        if ($(this).attr("href") == pgurl || $(this).attr("href") == '') {
            $(this).addClass("active");
            $(this).attr('style', 'color: #f39c12 !important');
        }
    });

});



