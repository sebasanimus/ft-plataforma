
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
  .setTween("#cta .parallaxParent > div.ctaParallax", {y: "80%", ease: Linear.easeNone})
  //.addIndicators({name: "parallax01"})
  .addTo(ctrl);


  // CTA build Tween
  var tween = new TimelineMax()
  tween
  /*.to("#cta", 1, { yPercent: 15, opacity: 0, delay: -0.5})*/
  .to("#ctaTxt", 1.5, { yPercent: -15, opacity: 0, delay: -1.8})
  // CTA 
  new ScrollMagic.Scene({
        triggerElement: "#cta",
        triggerHook: "onLeave", // show, when scrolled 10% into view
        duration: "100%", // use full viewport
        offset: -50 // move trigger to center of element
      })
      .setTween(tween)
      //.addIndicators({name: "CTA"}) // add indicators (requires plugin)
      .addTo(ctrl);


	  //webstory Parallax
new ScrollMagic.Scene({
	triggerElement: "#webstory",
	triggerHook: "onEnter",
	duration: "200%"
  })
  .setTween("#webstory .parallaxParent > div.webstoryParallax", {y: "80%", ease: Linear.easeNone})
  //.addIndicators({name: "parallax01"})
  .addTo(ctrl);


// Frase build Tween
var tween04 = new TimelineMax()
.add(TweenMax.from('#webstoryTxt', 1, {opacity: 0, delay: 0.5}))


// Frase build scene
new ScrollMagic.Scene({
	triggerElement: "#webstory",
	triggerHook: "onEnter", // show, when scrolled 10% into view
	duration: "100%", // use full viewport
	offset: -50 // move trigger to center of element
  })
  .setTween(tween04)
  //.addIndicators({name: "GSAP"}) // add indicators (requires plugin)
  .addTo(ctrl);

  // Prefooter build Tween
  var tween08 = new TimelineMax()
  tween08
  .from("#histories", 1.5, { yPercent: -30, opacity: 0, delay: 0.5})

  // Prefooter 
  new ScrollMagic.Scene({
	triggerElement: "#related",
	triggerHook: "onEnter", // show, when scrolled 10% into view
	duration: "60%", // use full viewport
	offset: 0 // move trigger to center of element
})
.setTween(tween08)
//.addIndicators({name: "CTA"}) // add indicators (requires plugin)
.addTo(ctrl);




}); 

 
})(jQuery, this);