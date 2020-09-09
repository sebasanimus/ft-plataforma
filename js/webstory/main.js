$(function() {
  $('a').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
          $('#container').animate({
          scrollTop: $('#container').scrollTop() + target.offset().top
          }, 1000);
          return false;
      }
      }
  });
});
 var swiper = new Swiper('.photoslider', {
	pagination: {
		el: '.swiper-pagination',
	},
	autoplay: {
		delay: 5000,
		disableOnInteraction: false,
	},
});

var swiper = new Swiper('.carroucel', {
	slidesPerView: 4,
	spaceBetween: 20,
      navigation: {
        nextEl: '.fotosNext',
        prevEl: '.fotosPrev',
	  },
	  autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      },
	  breakpoints: {
        1024: {
          slidesPerView: 3,
        },
        768: {
          slidesPerView: 3,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        320: {
          slidesPerView: 1,
          spaceBetween: 10,
        }
      }
});
var swiper = new Swiper('.logos', {
	slidesPerView: 6,
	spaceBetween: 20,
      navigation: {
        nextEl: '.logosNext',
        prevEl: '.logosPrev',
    },
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
	  breakpoints: {
        1024: {
          slidesPerView: 4,
        },
        768: {
          slidesPerView: 3,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        320: {
          slidesPerView: 1,
          spaceBetween: 10,
        }
      }
});
var swiper = new Swiper('.related', {
	slidesPerView: 4,
	spaceBetween: 0,
	breakpoints: {
        1024: {
          slidesPerView: 3.2,
        },
        768: {
          slidesPerView: 3.2,
        },
        640: {
          slidesPerView: 2.2,
        },
        320: {
          slidesPerView: 1.2,
        }
      }
});

(function() {

	var bodyEl = document.body,
		content = document.querySelector( '.content-wrap' ),
		openbtn = document.getElementById( 'open-button' ),
    closebtn = document.getElementById( 'close-button' ),
    closebtnlinks = document.getElementsByClassName('close');
		isOpen = false;

	function init() {
		initEvents();
	}

	function initEvents() {
		openbtn.addEventListener( 'click', toggleMenu );
		if( closebtn ) {
      closebtn.addEventListener( 'click', toggleMenu );
      
		}
    for (i = 0; i < closebtnlinks.length; i++) {
      closebtnlinks[i].addEventListener("click", toggleMenu);
    }
		// close the menu element if the target it´s not the menu element or one of its descendants..
		content.addEventListener( 'click', function(ev) {
			var target = ev.target;
			if( isOpen && target !== openbtn ) {
				toggleMenu();
			}
		} );
	}

	function toggleMenu() {
		if( isOpen ) {
			classie.remove( bodyEl, 'show-menu' );
		}
		else {
			classie.add( bodyEl, 'show-menu' );
		}
		isOpen = !isOpen;
	}

	init();

})();


// Create scene
(function ($, root, undefined) {
	$(function () {
		// Init ScrollMagic
    var ctrl = new ScrollMagic.Controller(
      {container: "#container"}
  );

  // PARALLAX CTA
  new ScrollMagic.Scene({
    triggerElement: "#ctaBox",
    triggerHook: "onEnter",
    duration: "200%"
  })
  .setTween("#ctaBox .parallaxParent > div.ctaParallax", {y: "80%", ease: Linear.easeNone})
  //.addIndicators({name: "parallax01"})
  .addTo(ctrl);


  // CTA build Tween
  var tween = new TimelineMax()
  tween
  .to("#cta", 1, { yPercent: 15, opacity: 0, delay: -0.5})
  .to("#share", 1.5, { yPercent: -15, opacity: 0, delay: -1.8})
  // CTA 
  new ScrollMagic.Scene({
        triggerElement: "#ctaBox",
        triggerHook: "onLeave", // show, when scrolled 10% into view
        duration: "100%", // use full viewport
        offset: -50 // move trigger to center of element
      })
      .setTween(tween)
      //.addIndicators({name: "CTA"}) // add indicators (requires plugin)
      .addTo(ctrl);

 // FADE IN CONTEXTO
  /*new ScrollMagic.Scene({
    triggerElement: "#contexto",
    triggerHook: 0.9, // show, when scrolled 10% into view
    duration: "80%", // hide 10% before exiting view (80% + 10% from bottom)
    offset: 0, // move trigger to center of element
    reverse: false // only do once
  })
  .setClassToggle(".contextoTxt", "fadeIn") // add class to reveal
  //.addIndicators() // add indicators (requires plugin)
  .addTo(ctrl);
*/

// iniciativa Implementada build Tween
var tween02 = new TimelineMax()
.add(TweenMax.from('#title01', 1, {xPercent: -5, opacity: 0, delay: 1}))
.add(TweenMax.from('#subtitle01', 1, {opacity: 0, delay: 0}))

// iniciativa Implementada build scene
new ScrollMagic.Scene({
      triggerElement: "#iniciativa",
      triggerHook: "onEnter", // show, when scrolled 10% into view
      duration: "100%", // use full viewport
      offset: 50 // move trigger to center of element
    })
    .setTween(tween02)
    //.addIndicators({name: "GSAP"}) // add indicators (requires plugin)
    .addTo(ctrl);


// La Solución build Tween
var tween03 = new TimelineMax()
.add(TweenMax.from('#title02', 1, {opacity: 0, delay: 0.5}))
.add(TweenMax.from('#subtitle02', 1, {opacity: 0, delay: -0.5}))

// La Solución build scene
new ScrollMagic.Scene({
      triggerElement: "#solucion",
      triggerHook: "onEnter", // show, when scrolled 10% into view
      duration: "100%", // use full viewport
      offset: 50 // move trigger to center of element
    })
    .setTween(tween03)
    //.addIndicators({name: "GSAP"}) // add indicators (requires plugin)
    .addTo(ctrl);


//FRASE Parallax
new ScrollMagic.Scene({
      triggerElement: "#frase",
      triggerHook: "onEnter",
      duration: "200%"
    })
    .setTween("#frase .parallaxParent > div.fraseParallax", {y: "80%", ease: Linear.easeNone})
    //.addIndicators({name: "parallax01"})
    .addTo(ctrl);


// Frase build Tween
var tween04 = new TimelineMax()
.add(TweenMax.from('#fraseTxt', 1, {opacity: 0, delay: 0.5}))
.add(TweenMax.from('#author', 1, {yPercent: -40, opacity: 0, delay: 0}))

// Frase build scene
new ScrollMagic.Scene({
      triggerElement: "#frase",
      triggerHook: "onEnter", // show, when scrolled 10% into view
      duration: "100%", // use full viewport
      offset: 50 // move trigger to center of element
    })
    .setTween(tween04)
    //.addIndicators({name: "GSAP"}) // add indicators (requires plugin)
    .addTo(ctrl);


// NUMEROS build scene
new ScrollMagic.Scene({
  triggerElement: "#contadores",
  triggerHook: "onEnter", // show, when scrolled 10% into view
  duration: "100%", // use full viewport
  offset: 50,
  reverse: false
})
.on('start', function () {
  
  console.log("passed trigger");
  $('.counter-value').each(function() {
	var $this = $(this),
	  countTo = $this.attr('data-count');
	$({
	  countNum: $this.text()
	}).animate({
		countNum: countTo
	  },

	  {

		duration: 2000,
		easing: 'swing',
		step: function() {
		  $this.text(Math.floor(this.countNum));
		},
		complete: function() {
		  $this.text(this.countNum);
		  //alert('finished');
		}

	  });
  });
})
//.addIndicators({name: "GSAP"}) // add indicators (requires plugin)
.addTo(ctrl);    



  // Resultados build Tween
  var tween05 = new TimelineMax()
  tween05
  .from("#title03", 1.5, { opacity: 0, delay: 0})

  // Resultados 
  new ScrollMagic.Scene({
        triggerElement: "#impactos_resultados",
        triggerHook: "onEnter", // show, when scrolled 10% into view
        duration: "100%", // use full viewport
        offset: 50 // move trigger to center of element
      })
      .setTween(tween05)
      //.addIndicators({name: "CTA"}) // add indicators (requires plugin)
      .addTo(ctrl);


  // estadisticas build Tween
var tween06 = new TimelineMax()
.add(TweenMax.from('#title04', 1, {opacity: 0, delay: 0.5}))
.add(TweenMax.from('#subtitle04', 1, {opacity: 0, delay: 0}))

// estadisticas build scene
new ScrollMagic.Scene({
      triggerElement: "#estadisticas",
      triggerHook: "onEnter", // show, when scrolled 10% into view
      duration: "100%", // use full viewport
      offset: 50 // move trigger to center of element
    })
    .setTween(tween06)
    //.addIndicators({name: "GSAP"}) // add indicators (requires plugin)
    .addTo(ctrl);


  //Video Parallax
  new ScrollMagic.Scene({
    triggerElement: "#video",
    triggerHook: "onEnter",
    duration: "200%"
  })
  .setTween("#video .parallaxParent > div.videoParallax", {y: "80%", ease: Linear.easeNone})
  //.addIndicators({name: "parallax01"})
  .addTo(ctrl);


  // VIDEO build Tween
  var tween06 = new TimelineMax()
  tween06
  .from("#play", 1.5, { opacity: 0, delay: 1})

  // VIDEO 
  new ScrollMagic.Scene({
        triggerElement: "#video",
        triggerHook: "onEnter", // show, when scrolled 10% into view
        duration: "100%", // use full viewport
        offset: 0 // move trigger to center of element
      })
      .setTween(tween06)
      //.addIndicators({name: "CTA"}) // add indicators (requires plugin)
      .addTo(ctrl);


        // Galeria build Tween
  var tween07 = new TimelineMax()
  tween07
  .from("#fotosBox", 1.5, { yPercent: -20, opacity: 0, delay: 0})

  // Galeria 
  new ScrollMagic.Scene({
        triggerElement: "#fotos",
        triggerHook: "onEnter", // show, when scrolled 10% into view
        duration: "60%", // use full viewport
        offset: 0 // move trigger to center of element
      })
      .setTween(tween07)
      //.addIndicators({name: "CTA"}) // add indicators (requires plugin)
      .addTo(ctrl);

    // infografia build Tween
var tween07 = new TimelineMax()
.add(TweenMax.from('#title05', 1, {opacity: 0, delay: 0.5}))
.add(TweenMax.from('#subtitle05', 1, {opacity: 0, delay: -0.5}))

// infografia build scene
new ScrollMagic.Scene({
      triggerElement: "#infografia",
      triggerHook: "onEnter", // show, when scrolled 10% into view
      duration: "100%", // use full viewport
      offset: 50 // move trigger to center of element
    })
    .setTween(tween07)
    //.addIndicators({name: "GSAP"}) // add indicators (requires plugin)
    .addTo(ctrl);


  // Prefooter build Tween
  var tween08 = new TimelineMax()
  tween08
  .from("#historias", 1.5, { yPercent: -30, opacity: 0, delay: 0.5})

  // Prefooter 
  new ScrollMagic.Scene({
        triggerElement: "#prefooter",
        triggerHook: "onEnter", // show, when scrolled 10% into view
        duration: "60%", // use full viewport
        offset: 0 // move trigger to center of element
      })
      .setTween(tween08)
      //.addIndicators({name: "CTA"}) // add indicators (requires plugin)
      .addTo(ctrl);

    // infografia build Tween
var tween07 = new TimelineMax()
.add(TweenMax.from('#title05', 1, {opacity: 0, delay: 0.5}))
.add(TweenMax.from('#subtitle05', 1, {opacity: 0, delay: -0.5}))


  });  
  
})(jQuery, this);


