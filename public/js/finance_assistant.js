function checkWidth(init)
{
    /*If browser resized, check width again */
    if ($(window).width() < 768) {
			$('.nav-pills').removeClass('navbar-center');
			$('.nav-pills').addClass('nav-stacked');
			$('.nav-pills').addClass('text-center');
    } else {
        if (!init) {
            $('.nav-pills').removeClass('nav-stacked');
			$('.nav-pills').removeClass('text-center');
			$('.nav-pills').addClass('navbar-center');
        }
    }
}

$(document).ready(function() {
    checkWidth(true);

    $(window).resize(function() {
        checkWidth(false);
    });
});


$(document).ready(function() {
    var date = new Date();

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;       
    $("#date").attr("value", today);
});