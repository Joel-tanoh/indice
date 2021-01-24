(function($) {
  
  "use strict";  

  $(window).on('load', function() {

  /* Page Loader active
    ========================================================*/
    $('#preloader').fadeOut();

  /* Sticky Nav
    ========================================================*/
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 100) {
			$('.scrolling-navbar').addClass('top-nav-collapse');
			$('#logo').attr('src', 'assets/img/logo/logo-colored.png');

        } else {
			$('.scrolling-navbar').removeClass('top-nav-collapse');
			$('#logo').attr('src', 'assets/img/logo/logo-white.png');
		}
    });

  /* slicknav mobile menu active 
    ========================================================*/
    $('.mobile-menu').slicknav({
        prependTo: '.navbar-header',
        parentTag: 'liner',
        allowParentLinks: true,
        duplicate: true,
        label: '',
        closedSymbol: '<i class="lni-chevron-right"></i>',
        openedSymbol: '<i class="lni-chevron-down"></i>',
      });

  /* WOW Scroll Spy
    ========================================================*/
    var wow = new WOW({
      //disabled for mobile
        mobile: false
    });
    wow.init();
    
  /* Nivo Lightbox 
  ========================================================*/
    $('.lightbox').nivoLightbox({
      effect: 'fadeScale',
      keyboardNav: true,
    });

  /* Counter
  ========================================================*/
    $('.counterUp').counterUp({
     delay: 10,
     time: 1000
    });

  /* Search
  ========================================================*/

  $('.search-query .form-control').on('click', function(e){
    e.stopPropagation();
    $(this).parent().toggleClass('query-focus');
  });

  $('body').on('click', function() {
    if ($('.search-query').hasClass('query-focus')) {
      $('.search-query').removeClass('query-focus');
    }
  });
  
  $('.search-suggestion').on('click', function(e) {
    e.stopPropagation();
  });

  /* Testimonials Carousel 
  ========================================================*/
    var owl = $("#testimonials");
      owl.owlCarousel({
        navigation: false,
        pagination: true,
        slideSpeed: 1000,
        stopOnHover: true,
        autoPlay: true,
        items: 2,
        itemsDesktop : [1199,2],
        itemsDesktopSmall : [980,2],
        itemsTablet: [768,1],
        itemsTablet: [767,1],
        itemsTabletSmall: [480,1],
        itemsMobile : [479,1],
      });        
      
  /* New Products Owl Carousel
  ========================================================*/
    $("#new-products").owlCarousel({
        navigation: true,
        pagination: false,
        slideSpeed: 1000,
        stopOnHover: true,
        autoPlay: false,
        items: 4,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [980,2],
        itemsTablet: [768,1],
        itemsTablet: [767,1],
        itemsTabletSmall: [480,1],
        itemsMobile : [479,1],
    });

    /* New Products Owl Carousel
  ========================================================*/
    $("#categories-icon-slider").owlCarousel({
        navigation: false,
        pagination: false,
        slideSpeed: 1000,
        stopOnHover: true,
        autoPlay: true,
        items: 5,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [980,4],
        itemsTablet: [768,3],
        itemsTablet: [767,3],
        itemsTabletSmall: [480,2],
        itemsMobile : [479,2],
    });

    var newProducts = $('.new-products');
    newProducts.find('.owl-prev').html('<i class="lni-chevron-left"></i>');
    newProducts.find('.owl-next').html('<i class="lni-chevron-right"></i>');

    var testiCarousel = $('.testimonials-carousel');
    testiCarousel.find('.owl-prev').html('<i class="lni-chevron-left"></i>');
    testiCarousel.find('.owl-next').html('<i class="lni-chevron-right"></i>');

    $('#new-products').find('.owl-prev').html('<i class="lni-chevron-left"></i>');
    $('#new-products').find('.owl-next').html('<i class="lni-chevron-right"></i>');

  /* owl Carousel active
  ========================================================*/   
     var owl;
    $(document).ready(function () {
        owl = $("#owl-demo");
        owl.owlCarousel({
            navigation: false, // Show next and prev buttons
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
            afterInit: afterOWLinit, // do some work after OWL init
            afterUpdate : afterOWLinit
        });

        function afterOWLinit() {
            // adding A to div.owl-page
            $('.owl-controls .owl-page').append('<a class="item-link" />');
            var pafinatorsLink = $('.owl-controls .item-link');
            /**
             * this.owl.userItems - it's your HTML <div class="item"><img src="http://www.ow...t of us"></div>
             */
            $.each(this.owl.userItems, function (i) {

                $(pafinatorsLink[i])
                    // i - counter
                    // Give some styles and set background image for pagination item
                    .css({
                        'background': 'url(' + $(this).find('img').attr('src') + ') center center no-repeat',
                        '-webkit-background-size': 'cover',
                        '-moz-background-size': 'cover',
                        '-o-background-size': 'cover',
                        'background-size': 'cover'
                    })
                    // set Custom Event for pagination item
                    .click(function () {
                        owl.trigger('owl.goTo', i);
                    });

            });
             // add Custom PREV NEXT controls
            $('.owl-pagination').prepend('<a href="#prev" class="prev-owl"/>');
            $('.owl-pagination').append('<a href="#next" class="next-owl"/>');
            // set Custom event for NEXT custom control
            $(".next-owl").click(function () {
                owl.trigger('owl.next');
            });
            // set Custom event for PREV custom control
            $(".prev-owl").click(function () {
                owl.trigger('owl.prev');
            });
          }
        });

    /* Editor Note Js
      ========================================================*/
      $('#summernote').summernote({
          height: 250,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: false,                // set focus to editable area after initializing summernote
          placeholder: 'Décrivez votre produit...',
          tabsize: 2,
          lang: 'fr-FR',
          toolbar: [
            ['undo', ['undo'] ],
            ['redo', ['redo'] ],
            ['style', ['style']],
            ['fontname', ['fontname', 'fontsize'] ],
            ['style', ['bold', 'italic', 'underline', 'clear'] ],
            ['font', ['strikethrough', 'superscript', 'subscript'] ],
            ['color', ['color'] ],
            ['height', ['height'] ],
            ['para', ['ul', 'ol', 'paragraph'] ],
            ['insert', ['link'] ],
            ['view', ['codeview', 'help'] ],
          ],
        });
      
    /* Back Top Link active
    ========================================================*/
      var offset = 200;
      var duration = 500;
      $(window).scroll(function() {
        if ($(this).scrollTop() > offset) {
          $('.back-to-top').fadeIn(400);
        } else {
          $('.back-to-top').fadeOut(400);
        }
      });

      $('.back-to-top').on('click',function(event) {
        event.preventDefault();
        $('html, body').animate({
          scrollTop: 0
        }, 600);
        return false;
      });

      /* Product Grids active
      ========================================================*/
      var itemList = $('.item-list');
      var gridStyle = $('.grid');
      var listStyle = $('.list');

      $('.list,switchToGrid').on('click',function(e) {
        e.preventDefault();
        itemList.addClass("make-list");
        itemList.removeClass("make-grid");
        itemList.removeClass("make-compact"); 
        gridStyle.removeClass("active");
        listStyle.addClass("active");
      });

      gridStyle.on('click',function(e) {
        e.preventDefault();
        listStyle.removeClass("active");
        $(this).addClass("active");
        itemList.addClass("make-grid");
        itemList.removeClass("make-list");
        itemList.removeClass("make-compact");
      });

      /* Hide enter price section if checkbox actived
      =======================================================*/
      $('#tg-priceoncall').click(function () {
        if (this.checked) {
          $('#enter_price_box').hide(250);
        } else {
          $('#enter_price_box').show(250);
        }
      });

      /* Hide or show someonelse section when user is posting announcement
      ====================================================================*/
      $('#tg-sameuser').click(function () {
        $('#someone_else').hide(500);
      });

      $('#tg-someoneelse').click(function () {
        $('#someone_else').show(500);
      });

      /** For Slider of Advertising
      ================================= */
      let index = 0;
      topSlider();
      rightSlider();
      leftSlider();

      /**
       * Créer un effet de Slide pour la barre en haut.
       */
      function topSlider() {
        let i;
        // On récupère les slides
        let slides = document.querySelectorAll(".advertising.top .slide");
        // On parcours le tableau des slides
        for(i = 0; i < slides.length; i++) { // On cache les images
          slides[i].style.display = "none";
        }

        index = index + 1;
        if (index > slides.length) {
          index = 1;
        }
        slides[index-1].style.display = "block";
        setTimeout(topSlider, 10000);
      }

      /**
       * Créer un effet de Slide pour la barre à gauche.
       */
      function leftSlider() {
        let i;
        // On récupère les slides
        let slides = document.querySelectorAll(".advertising.left .slide");
        // On parcours le tableau des slides
        for(i = 0; i < slides.length; i++) { // On cache les images
          slides[i].style.display = "none";
        }

        index = index + 1;
        if (index > slides.length) {
          index = 1;
        }
        slides[index-1].style.display = "block";
        setTimeout(leftSlider, 10000);
      }

      /**
       * Crée un effet de slide pour le coté droit.
       */
      function rightSlider() {
        let i;
        // On récupère les slides
        let slides = document.querySelectorAll(".advertising.right .slide");
        // On parcours le tableau des slides
        for(i = 0; i < slides.length; i++) { // On cache les images
          slides[i].style.display = "none";
        }

        index = index + 1;
        if (index > slides.length) {
          index = 1;
        }

        slides[index-1].style.display = "block";
        setTimeout(rightSlider, 10000);
      }

      /**
       * Crée un effet de slide pour les deux cotés.
       */
      function bothSideSlider() {
        let i;
        // On récupère les slides
        let slides = document.querySelectorAll(".advertising.side .slide");
        // On parcours le tableau des slides
        for(i = 0; i < slides.length; i++) { // On cache les images
          slides[i].style.display = "none";
        }

        index = index+1;
        if (index > slides.length) {
          index = 1;
        }
        slides[index-1].style.display = "block";
        setTimeout(bothSideSlider, 10000);
      }


  });      

}(jQuery));