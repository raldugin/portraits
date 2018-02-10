$(document).ready(function () {
    $('.dropdown-button').dropdown({
            constrainWidth: true, // Does not change width of dropdown to that of the activator
            hover: true, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: true, // Displays dropdown below the button
            alignment: 'left', // Displays dropdown with edge aligned to the left of button
            stopPropagation: false // Stops event propagation
        }
    );
    $('.dropdown-button-mobile').dropdown({
            constrainWidth: true, // Does not change width of dropdown to that of the activator
            hover: false, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: true, // Displays dropdown below the button
            alignment: 'left', // Displays dropdown with edge aligned to the left of button
            stopPropagation: false // Stops event propagation
        }
    );
    $('.button-collapse').sideNav();
    $('.collapsible').collapsible();
    $('.matchheight').matchHeight();
    stickyFooter();
    sizeImgMediaInside();
    stickyNav();

    function sizeImgMediaInside() {
        var windowHeight = window.innerHeight;
        var imgHeight = Math.round(windowHeight / 10 * 3);
        $('.imgMediaInside').height(imgHeight);
    }

    $(window).resize(function () {
        clearTimeout(t);
        var t = setTimeout(doAfterResize, 50);
    });

    function doAfterResize() {
        sizeImgMediaInside();
        stickyFooter();
        stickyNav();
    }
    function stickyFooter(){
        var footer = $(".page-footer");
        if( ($('#page-wrapper').outerHeight(true) + $(footer).outerHeight(true)) <= $(window).height() )
        {
            $(footer).addClass("footer-bar-fixed-bottom");
        }
        else{
            $(footer).removeClass("footer-bar-fixed-bottom");
        }
    }
});

function windowWidth(){
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    var vwidth = e[ a+'Width' ];
    return vwidth;
}

var stickyNavTop = $('#pushpin').offset().top;
var stickyNav = function(){
    var scrollTop = $(window).scrollTop();

    if (scrollTop > stickyNavTop && windowWidth() > 1024) {
        var pushpin_card = $('.pushpin_card').outerWidth() - (parseInt($('.pushpin_card').css('padding-left')) * 2);
        $('#pushpin').addClass('pushpin_fixed');
        $('.pushpin_fixed').css({width: pushpin_card})
    } else {
        $('#pushpin').removeClass('pushpin_fixed');
    }
};

$('.linkTO').click(function () {
    var linkTO = $(this).attr('data-link');
    $('html, body').animate({
        scrollTop: $(linkTO).offset().top
    }, 300);
});


$(window).scroll(function() {
    stickyNav();
});

/*$(document).ready(function(){
    $('#pushpin').pushpin({ top: $('#pushpin').offset().top });
});*/
