$(document).ready( function () {
    $('.slider').slider({
        'indicators':false,
        'interval': 6000,
        'transition': 2000,
        'height': '100%'
    });

    $('.modal').modal();
});

//Background slide
/*$(document).ready(function() {
 $("body").backgroundCycle({
 imageUrls: [
 'content/bck/bck1.jpg',
 'content/bck/bck2.jpg',
 'content/bck/bck3.jpg',
 'content/bck/bck4.jpg'
 ],
 fadeSpeed: 2000,
 duration: 5000,
 backgroundSize: SCALING_MODE_COVER
 });
 });*/
//Welcome screen
$(document).ready(function() {
    var menu = $('#menu');
    $('#logo').delay(300).animate({top: ['0', 'swing']}, 800);
    $('#front').delay(900).fadeOut(600);
    $('#player iframe').delay(1200).fadeIn(600);
    $('#social ul li:nth-child(1)').delay(1200).animate({top: ['0', 'swing']}, 300);
    $('#social ul li:nth-child(2)').delay(1300).animate({top: ['0', 'swing']}, 300);
    $('#social ul li:nth-child(3)').delay(1400).animate({top: ['0', 'swing']}, 300);
    $('#social ul li:nth-child(4)').delay(1500).animate({top: ['0', 'swing']}, 300);

    menu.delay(1200).animate({left: 0}, 600);
    $('#bck').delay(1200).animate({opacity: '1'}, 300);

    $('#pres').delay(1200).animate({right : 0}, 600);
    $('#menu ul li:nth-child(1) a').delay(1200).addClass('active');
});

// Menu
$(document).ready(function() {
    var content;

    $('#menu ul li a').on('click', function(e) {
        var content = $(this).attr('href');
        var notContent = $('.content').not(content);

        e.preventDefault();
        $(notContent).animate({right: '-65%'}, 500);
        $(content).animate({right: 0}, 500);
        $('#menu ul li a').removeClass('active');
        $(this).addClass('active');
    });
});

//changements de lanques sur la bio
$(document).ready( function () {
    $('#button_lang a').on('click', function(e) {
        var lang = $(this).attr('href');
        var speed = 500;

        e.preventDefault();
        $(lang).next('.bio').fadeOut(speed);
        $(lang).prev('.bio').fadeOut(speed);
        $(lang).fadeIn(speed);

        $(this).next('#button_lang a').removeClass('clicked');
        $(this).prev('#button_lang a').removeClass('clicked');
        $(this).not('.clicked').addClass('clicked');

    });
});

//Déroulement infos #date
$(document).ready(function() {
    $('.tour_item').on('click', function(){
        var coord = $(this).find('.tour_focus');
        $('.tour_focus').not(coord).slideUp();
        coord.slideToggle();
    })
});

