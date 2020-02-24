/*
1- Home slider
2- Accordian
3- Navigation
4- Tabs
5- Google Maps
*/
jQuery(function ($) {
    "use strict";
  
    
    
    $("#sticktop").sticky({
        topSpacing: 0
    });
    
    /*============================
		6-Flicker
		============================*/
	
		if($('#flicker-feed').length){
			$('#flicker-feed').jflickrfeed({
				limit: $('#flicker-feed').data('limit'),
				qstrings: {id: $('#flicker-feed').attr('data-userID')},
				itemTemplate: '<li><a href="{{image_b}}" data-rel="prettyPhoto"><img alt="{{title}}" src="{{image_s}}" /></a></li>'
			}, function () {$("a[data-rel^='prettyPhoto']").prettyPhoto();});
		}
    
    /*==========Home slider===============*/

    $('#home-slider').flexslider({
        animation: "slide",
        directionNav: true,
        controlNav: true,
        pauseOnHover: true,
        slideshowSpeed: 7000,
        slideshow: true,
        prevText:"",
        nextText:"",
        direction: "horizontal", //Direction of slides
        start: function () {
            $(window).trigger('resize');
            $('.xv_slider .animated').addClass("go").removeClass("goAway");
        },
        before: function () {
            $('.xv_slider .animated').addClass("goAway").removeClass("go");
        },
        after: function () {
            $('.xv_slider .animated').addClass("go").removeClass("goAway");
        }
    });

    if ($('.xv_slider').length) {
        $('.xv_slide').each(function () {
            $(this).css('background-image', function () {
                return $(this).attr('data-slideBg');
            });
        });

    }


    /*============
    Accordian
    ================*/

    $("body").on("click", ".accordian-trigger", function (e) {
        e.preventDefault();
        $(this).parents(".accordian-wrapper").toggleClass("active");
        $(this).parents(".accordian-wrapper").find(".accordian-pane").slideToggle();
    });

    /*==============
    Navigation
    ==============*/

    $("body").on("click", ".nav-triger", function (e) {
        e.preventDefault();
        $(".offsetWrap").toggleClass("active");
    });

    $('body').on("click", function (e) {
        if (!$(e.target).closest('.navOffset,.doc-header').length) {
            $(".offsetWrap").removeClass('active');
        }
    });


    $(".offsetMaker").prepend('<nav class="navOffset"><ul>' + $(".main-menu").html() + '</ul></nav>');

    /*================
    Tabs
    =================*/
    
    $("body").on("click", ".tabs a", function (e) {
        e.preventDefault();
        var $this = $(this);
        $(".tabs li").removeClass("active");
        $this.parent().addClass("active");
        $(".tab-pane").removeClass("active");
        $($this.attr("href") + ".tab-pane").addClass("active");
    });

    /*================================
	Google Maps
	================================*/

    

    function contactemaps(selector, address, type, zoom_lvl) {
        var map_pin = "assets/img/basic/map-pin.png",
            geocoder = new google.maps.Geocoder(),
            map = new google.maps.Map(document.getElementById(selector), {
                mapTypeId: google.maps.MapTypeId.type,
                scrollwheel: false,
                draggable: false,
                zoom: zoom_lvl
            });
        
        geocoder.geocode({
            'address': address
        },
            function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                        icon: map_pin
                    });
                    map.setCenter(results[0].geometry.location);
                }
            });
    }

    if ($('#contact-map').length) {
        var contact_map = 'contact-map',
            mapAddress = $('#contact-map').data('address'),
            mapType = $('#contact-map').data('maptype'),
            zoomLvl = $('#contact-map').data('zoomlvl');
        contactemaps(contact_map, mapAddress, mapType, zoomLvl);

    }


}); /*end ready*/ /*end require*/