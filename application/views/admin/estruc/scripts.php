<script src="material/assets/js/core/jquery.min.js"></script>
	<script src="material/assets/js/core/popper.min.js"></script>
	<script src="material/assets/js/core/bootstrap-material-design.min.js"></script>
	<script src="material/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
	<!-- Plugin for the momentJs  -->
	<script src="material/assets/js/plugins/moment-with-locales.js"></script>
	<!--  Plugin for Sweet Alert -->
	<script src="material/assets/js/plugins/sweetalert2.js"></script>
	
	<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
	<script src="material/assets/js/core.min.js"></script>
	<!-- Library for adding dinamically elements -->
	<script src="material/assets/js/plugins/arrive.min.js"></script>
	<!-- Place this tag in your head or just before your close body tag. -->
	<script async defer src="material/assets/js/buttons.js"></script>
	<!--  Notifications Plugin    -->
	<script src="material/assets/js/plugins/bootstrap-notify.js"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
	<script src="material/assets/js/plugins/bootstrap-selectpicker.js"></script>
	

	<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
	<script src="material/assets/js/material-dashboard.minf066.js?v=2.1.0" type="text/javascript"></script>
	<!-- Material Dashboard DEMO methods, don't include it in your project! 
	<script src="material/assets/demo/demo.js"></script>-->
	<script>
		const TITULO = document.title;
                $(document).ready(function() {
                  $().ready(function() {
                    $sidebar = $('.sidebar');

                    $sidebar_img_container = $sidebar.find('.sidebar-background');

                    $full_page = $('.full-page');

                    $sidebar_responsive = $('body > .navbar-collapse');

                    window_width = $(window).width();

                    fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                    if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                      if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                        $('.fixed-plugin .dropdown').addClass('open');
                      }

                    }

                    $('.fixed-plugin a').click(function(event) {
                      // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                      if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                          event.stopPropagation();
                        } else if (window.event) {
                          window.event.cancelBubble = true;
                        }
                      }
                    });

                    $('.fixed-plugin .active-color span').click(function() {
                      $full_page_background = $('.full-page-background');

                      $(this).siblings().removeClass('active');
                      $(this).addClass('active');

                      var new_color = $(this).data('color');

                      if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                      }

                      if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                      }

                      if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                      }
                    });

                    $('.fixed-plugin .background-color .badge').click(function() {
                      $(this).siblings().removeClass('active');
                      $(this).addClass('active');

                      var new_color = $(this).data('background-color');

                      if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                      }
                    });

                    $('.fixed-plugin .img-holder').click(function() {
                      $full_page_background = $('.full-page-background');

                      $(this).parent('li').siblings().removeClass('active');
                      $(this).parent('li').addClass('active');


                      var new_image = $(this).find("img").attr('src');

                      if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                          $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                          $sidebar_img_container.fadeIn('fast');
                        });
                      }

                      if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                          $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                          $full_page_background.fadeIn('fast');
                        });
                      }

                      if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                      }

                      if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                      }
                    });

                    $('.switch-sidebar-image input').change(function() {
                      $full_page_background = $('.full-page-background');

                      $input = $(this);

                      if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                          $sidebar_img_container.fadeIn('fast');
                          $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                          $full_page_background.fadeIn('fast');
                          $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                      } else {
                        if ($sidebar_img_container.length != 0) {
                          $sidebar.removeAttr('data-image');
                          $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                          $full_page.removeAttr('data-image', '#');
                          $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                      }
                    });

                    $('.switch-sidebar-mini input').change(function() {
                      $body = $('body');

                      $input = $(this);

                      if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                      } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                          $('body').addClass('sidebar-mini');

                          md.misc.sidebar_mini_active = true;
                        }, 300);
                      }

                      // we simulate the window Resize so the charts will get updated in realtime.
                      var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                      }, 180);

                      // we stop the simulation of Window Resize after the animations are completed
                      setTimeout(function() {
                        clearInterval(simulateWindowResize);
					  }, 1000);					  

					});
					
					  // check active menu
					CURRENT_URL = window.location.href.split('#')[0].split('?')[0];
					$SIDEBAR_MENU = $('.sidebar');
					$SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('active');

					$SIDEBAR_MENU.find('a').filter(function () {
						return this.href == CURRENT_URL;
					}).parent('li').addClass('active').parent('ul').parent('div').addClass('show').parent().addClass('active');

					checkAlertas();
					setInterval(function(){ checkAlertas(); }, 60*1000);
                  });
                });				
              </script>

<script>
	function checkAlertas(){
		$.get( "alertas/getAlertas").done(function( data ) {
			var datos = JSON.parse(data);
			//console.log(datos);
			$('#alertas').html('');
			var sinVer = 0;
			for(var i=0; i<datos.alertas.length; i++){
				var bold = '';
				if(datos.alertas[i].leido==null){
					sinVer++;
					bold = 'font-weight-bold'
				}
				$('#alertas').append('<a class="dropdown-item dropdown-item-rose '+bold+'" href="javascript:verAlerta('+datos.alertas[i]['idalerta']+')">'+datos.alertas[i]['titulo']+'  &nbsp; &nbsp;&nbsp;<small>'+datos.alertas[i]['created']+'</small></a><div class="dropdown-divider"></div>')
				
			}
			if(sinVer==0){
				$('#alertaNum').hide();
				document.title = TITULO;
			}else{
				$('#alertaNum').html(sinVer);
				$('#alertaNum').show();
				document.title = '('+sinVer+') '+TITULO;
			}				
		});
	}

	function verAlerta(idalerta){
		$.post( "alertas/getAlerta", {idalerta:idalerta}).done(function( data ) {
			var datos = JSON.parse(data);
			Swal.fire({
				title: datos.alerta.titulo,
				html: datos.alerta.contenido,
				type: 'info',
				showCancelButton: true,
				showCloseButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ok',
				cancelButtonText: 'Eliminar Alerta'
			}).then((result) => {
				if (result.value) {//ver
					if(datos.alerta.link!=''){
						window.location.href = datos.alerta.link;
					}
				} else if (result.dismiss === Swal.DismissReason.cancel) {//eliminar alerta
					$.post( "alertas/cerrarAlerta", {idalerta:idalerta}).done(function( data ) {checkAlertas();});
				}
			});
			checkAlertas();
		});
	}
</script>


<?php
	if(isset($libs)){
        foreach($libs as $lib){
            if (file_exists(APPPATH."views/admin/headscripts/lib_{$lib}_scripts.php")){
                $this->load->view("admin/headscripts/lib_{$lib}_scripts.php");
            }
        }
    }
    if (isset($page) && file_exists(APPPATH."views/admin/headscripts/{$page}_scripts.php")){
        $this->load->view('admin/headscripts/'.$page.'_scripts');
	}
?>