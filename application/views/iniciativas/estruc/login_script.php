 
 <?php $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0') !== false && strpos($ua, 'rv:11.0') !== false)) :?>
  <script>  
    alert('El navegador que está utilizando no se encuentra soportado. Le recomendamos utilizar una versión actualizada de Chrome, Firefox o Edge para un correcto funcionamiento de la plataforma.')
  </script>
<?php endif; ?>
<!--   Core JS Files   -->
 <script src="material/assets/js/core/jquery.min.js"></script>
  <script src="material/assets/js/core/popper.min.js"></script>
  <script src="material/assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="material/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="material/assets/js/material-dashboard.minf066.js?v=2.1.0" type="text/javascript"></script>
  


  <script>
    $(document).ready(function() {
      md.checkFullPageBackgroundImage();
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>